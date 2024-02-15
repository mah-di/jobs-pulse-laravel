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

    public function updateStatus(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:ACCEPTED,REJECTED']
            ]);

            $application = JobApplication::find($id);

            if (!$application)
                throw new Exception("Invalid request");

            if ($application->job()->pluck('company_id')->first() !== $request->user()->company_id)
                throw new Exception("Unauthorized request");

            $application->status = $request->status;
            $application->save();

            return ResponseHelper::make(
                'success',
                null,
                'Application ' . strtolower($request->status) . '!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            $candidateId = $request->user()->candidateProfile()->pluck('id')->first();

            $result = JobApplication::where(['id' => $id, 'candidate_profile_id' => $candidateId])->whereNot('status', 'ACCEPTED')->delete();

            if (!$result)
                throw new Exception("Unauthorized request.");

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

    public function receivedApplications(Request $request, string $jobId)
    {
        try {
            $exists = Job::where(['id' => $jobId, 'company_id' => $request->user()->company_id])->exists();

            if (!$exists)
                throw new Exception("Unauthorized request");

            $q = JobApplication::where('job_id', $jobId);

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
