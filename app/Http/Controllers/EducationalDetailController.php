<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\CandidateProfile;
use App\Models\EducationalDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class EducationalDetailController extends Controller
{
    public function save(Request $request)
    {
        try {
            $request->validate([
                'degreeType' => ['required', 'in:SSC,HSC,Bachelor/Honors'],
                'institution' => ['required', 'min:10'],
                'department' => ['required'],
                'cgpa' => ['required', 'numeric', 'gt:0', 'lte:5'],
                'passingYear' => ['required', 'numeric', 'gte:1900', 'lte:' . now()->year],
            ]);

            $candidateProfileId = $request->user()->candidateProfile()->pluck('id')->first();

            $certificate = EducationalDetail::where(['candidate_profile_id' => $candidateProfileId, 'degreeType' => $request->degreeType])->pluck('certificate')->first();
            $rule = $certificate ? 'nullable' : 'required';

            $request->validate([
                'certificate' => [$rule, FileRule::image()->max(2048)]
            ]);

            if ($request->hasFile('certificate')) {
                ImageHelper::delete($certificate);

                $certificate = ImageHelper::save($request->file('certificate'), 'certificates');
            }

            $data = EducationalDetail::updateOrCreate(
                ['candidate_profile_id' => $candidateProfileId, 'degreeType' => $request->degreeType],
                [
                    'candidate_profile_id' => $candidateProfileId,
                    'degreeType' => $request->degreeType,
                    'institution' => $request->institution,
                    'department' => $request->department,
                    'cgpa' => $request->cgpa,
                    'certificate' => $certificate,
                    'passingYear' => $request->passingYear,
                ]
            );

            return ResponseHelper::make(
                'success',
                $data,
                "{$request->degreeType} details saved!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(Request $request, EducationalDetail $education)
    {
        return ResponseHelper::make(
            'success',
            $education,
        );
    }

    public function showAll(Request $request, CandidateProfile $profile)
    {
        try {
            $data = EducationalDetail::where(['candidate_profile_id' => $profile->id])->get();

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
