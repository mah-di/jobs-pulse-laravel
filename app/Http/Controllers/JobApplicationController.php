<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Job;
use App\Models\JobApplication;
use Exception;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function create(Request $request, string $jobId)
    {
        try {
            $candidateId = $request->user()->candidateProfile()->pluck('id')->first();

            $status = Job::where('id', $jobId)->pluck('status')->first();

            if ($status !== "AVAILABLE")
                throw new Exception("Invalid request");

            $data = JobApplication::updateOrCreate(
                [
                    'candidate_profile_id' => $candidateId,
                    'job_id' => $jobId,
                ],
                [
                    'candidate_profile_id' => $candidateId,
                    'job_id' => $jobId,
                ]
            );

            return ResponseHelper::make(
                'success',
                $data,
                'Job Application was successfully registered.'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:ACCEPTED,REJECTED']
            ]);

            $application->update(['status' => $request->status]);

            return ResponseHelper::make(
                'success',
                null,
                'Application ' . strtolower($request->status) . '!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, JobApplication $application)
    {
        try {
            $application->delete();

            return ResponseHelper::make(
                'success',
                null,
                'Job Application deleted.'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function candidateApplications(Request $request)
    {
        try {
            $candidateId = $request->user()->candidateProfile()->pluck('id')->first();

            $q = JobApplication::where('candidate_profile_id', $candidateId);

            if ($request->query('status'))
                $q = $q->where('status', $request->query('status'));

            $data = $q->with('job')->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function receivedApplications(Request $request, Job $job)
    {
        try {
            $q = JobApplication::where('job_id', $job->id);

            if ($request->query('status'))
                $q = $q->where('status', $request->query('status'));

            $data = $q->with('candidate')->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function receivedApplicationCount(Request $request, string $jobId)
    {
        try {
            $data = JobApplication::where('job_id', $jobId)->count();

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
