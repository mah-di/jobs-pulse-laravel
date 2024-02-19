<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\CandidateProfile;
use App\Models\Training;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class TrainingController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => ['required', 'min:5'],
                'institution' => ['required'],
                'certificate' => ['nullable', FileRule::image()->max(2048)],
                'completionYear' => ['required', 'numeric', 'gte:1900', 'lte:' . now()->year],
            ]);

            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            $imgPath = null;

            if ($request->hasFile('certificate'))
                $imgPath = ImageHelper::save($request->file('certificate'), 'certificates');

            $data = Training::create([
                    'candidate_profile_id' => $candidateProfileId,
                    'title' => $request->title,
                    'institution' => $request->institution,
                    'certificate' => $imgPath,
                    'completionYear' => $request->completionYear,
                ]);

            return ResponseHelper::make(
                'success',
                $data,
                "Training saved!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function update(Request $request, Training $training)
    {
        try {
            $request->validate([
                'title' => ['required', 'min:5'],
                'institution' => ['required'],
                'certificate' => ['nullable', FileRule::image()->max(2048)],
                'completionYear' => ['required', 'numeric', 'gte:1900', 'lte:' . now()->year],
            ]);

            $certificate = $training->certificate;

            if ($request->hasFile('certificate')) {
                ImageHelper::delete($certificate);

                $certificate = ImageHelper::save($request->file('certificate'), 'certificates');
            }

            $training->update([
                    'title' => $request->title,
                    'institution' => $request->institution,
                    'certificate' => $certificate,
                    'completionYear' => $request->completionYear,
                ]);

            return ResponseHelper::make(
                'success',
                null,
                "Training saved!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(Request $request, Training $training)
    {
        return ResponseHelper::make(
            'success',
            $training,
        );
    }

    public function showAll(Request $request, CandidateProfile $profile)
    {
        try {
            $data = Training::where(['candidate_profile_id' => $profile->id])->get();

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, Training $training)
    {
        try {
            ImageHelper::delete($training->certificate);

            $training->delete();

            return ResponseHelper::make(
                'success',
                null,
                'Training was deleted'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
