<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
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

            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            if (!$candidateProfileId)
                throw new Exception("Please save your profile informaion first");

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

    public function update(Request $request, string $id)
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

            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            $profileId = JobExperience::where('id', $id)->pluck('candidate_profile_id')->first();

            if ($candidateProfileId !== $profileId)
                throw new Exception("Unauthorized request");

            $data = JobExperience::where('id', $id)->update([
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

    public function show(Request $request, string $id)
    {
        try {
            $data = JobExperience::find($id);

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function showAll(Request $request, string $profileId)
    {
        try {
            $data = JobExperience::where(['candidate_profile_id' => $profileId])->get();

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            $profileId = JobExperience::where('id', $id)->pluck('candidate_profile_id')->first();

            if ($candidateProfileId !== $profileId)
                throw new Exception("Unauthorized request");

            JobExperience::where('id', $id)->delete();

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
