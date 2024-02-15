<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
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

            if (!$candidateProfileId)
                throw new Exception("Please save your profile informaion first");

            $url = null;

            if ($request->hasFile('certificate')) {
                $img = $request->file('certificate');
                $filename = uuid_create() . '.' . $img->getClientOriginalExtension();
                $url = "storage/uploads/certificates/{$filename}";
                $img->storeAs('uploads/certificates', $filename);
            }

            $data = Training::create([
                    'candidate_profile_id' => $candidateProfileId,
                    'title' => $request->title,
                    'institution' => $request->institution,
                    'certificate' => $url,
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

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'title' => ['required', 'min:5'],
                'institution' => ['required'],
                'certificate' => ['nullable', FileRule::image()->max(2048)],
                'completionYear' => ['required', 'numeric', 'gte:1900', 'lte:' . now()->year],
            ]);

            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            $training = Training::where('id', $id)->select(['candidate_profile_id', 'certificate'])->first();

            if ($candidateProfileId !== $training->candidate_profile_id)
                throw new Exception("Unauthorized request");

            $certificate = $training->certificate;

            if ($request->hasFile('certificate')) {
                if ($certificate and File::exists(public_path($certificate)))
                    File::delete(public_path($certificate));

                $img = $request->file('certificate');
                $filename = uuid_create() . '.' . $img->getClientOriginalExtension();
                $certificate = "storage/uploads/certificates/{$filename}";
                $img->storeAs('uploads/certificates', $filename);
            }

            $data = Training::where('id', $id)->update([
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

    public function show(Request $request, string $id)
    {
        try {
            $data = Training::find($id);

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
            $data = Training::where(['candidate_profile_id' => $profileId])->get();

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

            $training = Training::where('id', $id)->select(['candidate_profile_id', 'certificate'])->first();

            if ($candidateProfileId !== $training->candidate_profile_id)
                throw new Exception("Unauthorized request");

            if ($training->certificate and File::exists(public_path($training->certificate)))
                File::delete(public_path($training->certificate));

            Training::where('id', $id)->delete();

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
