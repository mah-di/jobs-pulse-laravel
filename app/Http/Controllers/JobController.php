<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Company;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'job_category_id' => ['required', 'exists:job_categories,id'],
                'title' => ['required', 'min:5'],
                'description' => ['required'],
                'skills' => ['required', 'string'],
                'salary' => ['required'],
                'type' => ['required', 'in:On-Site,Remote,Hybrid'],
                'deadline' => ['required', 'date'],
            ]);

            $companyId = $request->user()->company_id;

            $data = Job::create([
                'job_category_id' => $request->job_category_id,
                'company_id' => $companyId,
                'title' => $request->title,
                'description' => $request->description,
                'skills' => $request->skills . ',',
                'salary' => $request->salary,
                'type' => $request->type,
                'deadline' => $request->deadline,
            ]);

            return ResponseHelper::make(
                'success',
                $data,
                "Job created, pending approval!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function update(Request $request, Job $job)
    {
        try {
            $request->validate([
                'job_category_id' => ['required', 'exists:job_categories,id'],
                'title' => ['required', 'min:5'],
                'description' => ['required'],
                'skills' => ['required', 'string'],
                'salary' => ['required'],
                'type' => ['required', 'in:On-Site,Remote,Hybrid'],
                'deadline' => ['required', 'date'],
            ]);

            $job->update([
                'job_category_id' => $request->job_category_id,
                'title' => $request->title,
                'description' => $request->description,
                'skills' => $request->skills . ',',
                'salary' => $request->salary,
                'type' => $request->type,
                'deadline' => $request->deadline,
            ]);

            return ResponseHelper::make(
                'success',
                null,
                'Job updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function updateAvailability(Request $request, Job $job)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:AVAILABLE,UNAVAILABLE'],
            ]);

            $job->update(['status' => $request->status]);

            return ResponseHelper::make(
                'success',
                null,
                'Job availability set to "' . strtolower($request->status) . '"!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function approve(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
                'companyId' => ['required'],
            ]);

            DB::beginTransaction();

            $data = Job::where(['id' => $request->id])->update(['status' => "AVAILABLE", 'restrictionFeedback' => null]);

            $jobsPosted = Job::where('company_id', $request->companyId)->whereNotIn('status', ['PENDING', 'RESTRICTED'])->count();

            Company::where('id', $request->companyId)->update(['jobsPosted' => $jobsPosted]);

            DB::commit();

            return ResponseHelper::make(
                'success',
                null,
                'Job approved!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function restrict(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
                'companyId' => ['required'],
                'restrictionFeedback' => ['required'],
            ]);

            DB::beginTransaction();

            $data = Job::where(['id' => $request->id])->update(['status' => "RESTRICTED", 'restrictionFeedback' => $request->restrictionFeedback]);

            $jobsPosted = Job::where('company_id', $request->companyId)->whereNotIn('status', ['PENDING', 'RESTRICTED'])->count();

            Company::where('id', $request->companyId)->update(['jobsPosted' => $jobsPosted]);

            DB::commit();

            return ResponseHelper::make(
                'success',
                null,
                'Job has been restricted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = Job::with('company')->find($id);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function showLatest(Request $request, string $categoryId)
    {
        try {
            $data = Job::where(['job_category_id' => $categoryId, 'status' => 'available'])->latest()->with('company')->take(5)->get();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $q = Job::where('status', 'available');

            if ($request->query('q'))
                $q = $q->where('title', 'LIKE', "%{$request->query('q')}%");

            if ($request->query('category'))
                $q = $q->where('job_category_id', '=', $request->query('category'));

            if ($request->query('skill'))
                $q = $q->where('skills', 'LIKE', "%{$request->query('skill')},%");

            if ($request->query('type'))
                $q = $q->where('type', '=', $request->query('type'));

            $data = $q->with('company')->paginate(20)->withQueryString();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function jobsByCompany(Request $request, string $companyId)
    {
        try {
            $data = Job::where(['company_id' => $companyId, 'status' => 'AVAILABLE'])->with('company')->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getCompanyJobs(Request $request)
    {
        try {
            $q = Job::where('company_id', $request->user()->company_id);

            if ($request->query('skill'))
                $q = $q->where('skills', 'LIKE', "%{$request->query('skill')},%");

            if ($request->query('type'))
                $q = $q->where('type', '=', $request->query('type'));

            if ($request->query('status'))
                $q = $q->where('status', '=', $request->query('status'));

            $data = $q->withCount('jobApplications')->orderByDesc('deadline')->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getJobsByStatus(string $status)
    {
        try {
            $data = Job::where('status', $status)->with('company')->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
