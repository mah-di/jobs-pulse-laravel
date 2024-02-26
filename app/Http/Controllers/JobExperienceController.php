<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\CandidateProfile;
use App\Models\JobExperience;
use Exception;
use Illuminate\Http\Request;

class JobExperienceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'designation' => ['required', 'min:5'],
                'company' => ['required', 'min:5'],
                'jobDetails' => ['required', 'min:20'],
                'isCurrentJob' => ['required'],
                'joiningDate' => ['required', 'date'],
                'quittingDate' => ['nullable', 'date'],
            ]);

            if (!$request->isCurrentJob and !$request->quittingDate)
                throw new Exception("Quitting Date is required");

            if ($request->isCurrentJob and $request->quittingDate)
                throw new Exception("Current Job Can't Have a Quitting Date");

            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            $data = JobExperience::create([
                    'candidate_profile_id' => $candidateProfileId,
                    'designation' => $request->designation,
                    'company' => $request->company,
                    'jobDetails' => $request->jobDetails,
                    'isCurrentJob' => $request->isCurrentJob ?? false,
                    'joiningDate' => $request->joiningDate,
                    'quittingDate' => $request->quittingDate,
                ]);

            return ResponseHelper::make(
                'success',
                $data,
                "Job Experience saved!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function update(Request $request, JobExperience $experience)
    {
        try {
            $request->validate([
                'designation' => ['required', 'min:5'],
                'company' => ['required', 'min:5'],
                'jobDetails' => ['required', 'min:20'],
                'isCurrentJob' => ['required'],
                'joiningDate' => ['required', 'date'],
                'quittingDate' => ['nullable', 'date'],
            ]);

            if (!$request->isCurrentJob and !$request->quittingDate)
                throw new Exception("Quitting Date is required");

            $experience->update([
                    'designation' => $request->designation,
                    'company' => $request->company,
                    'jobDetails' => $request->jobDetails,
                    'isCurrentJob' => $request->isCurrentJob ?? false,
                    'joiningDate' => $request->joiningDate,
                    'quittingDate' => $request->quittingDate,
                ]);

            return ResponseHelper::make(
                'success',
                null,
                "Job Experience saved!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(Request $request, JobExperience $experience)
    {
        return ResponseHelper::make(
            'success',
            $experience,
        );
    }

    public function showAll(Request $request, CandidateProfile $profile)
    {
        try {
            $data = JobExperience::where(['candidate_profile_id' => $profile->id])->orderByDesc('joiningDate')->get();

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, JobExperience $experience)
    {
        try {
            $experience->delete();

            return ResponseHelper::make(
                'success',
                null,
                'Job Experience was deleted'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
