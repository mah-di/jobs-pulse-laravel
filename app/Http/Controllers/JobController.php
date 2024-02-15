<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;

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

    public function update(Request $request, string $id)
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

            $data = Job::where(['id' => $id, 'company_id' => $companyId])->update([
                'job_category_id' => $request->job_category_id,
                'title' => $request->title,
                'description' => $request->description,
                'skills' => $request->skills . ',',
                'salary' => $request->salary,
                'type' => $request->type,
                'deadline' => $request->deadline,
            ]);

            if (!$data)
                throw new Exception("Unauthorized request");

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function updateAvailability(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:AVAILABLE,UNAVAILABLE'],
            ]);

            $companyId = $request->user()->company_id;

            $data = Job::where(['id' => $id, 'company_id' => $companyId])->update(['status' => $request->status]);

            if (!$data)
                throw new Exception("Unauthorized request");

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:AVAILABLE,RESTRICTED'],
            ]);

            $data = Job::where(['id' => $id])->update(['status' => $request->status]);

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = Job::find($id);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function showAll(string $categoryId)
    {
        try {
            $data = Job::where(['job_category_id' => $categoryId, 'status' => 'available'])->paginate(20);

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

            if ($request->query('skill'))
                $q = $q->where('skills', 'LIKE', "%{$request->query('skill')},%");

            if ($request->query('type'))
                $q = $q->where('type', '=', $request->query('type'));

            $data = $q->paginate(20);

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

            $data = $q->paginate(20);

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
            $data = Job::where('status', $status)->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function getJobsCount()
    {
        try {
            $data = Job::count();

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
