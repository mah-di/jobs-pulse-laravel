<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\CandidateProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class CandidateProfileController extends Controller
{
    public function show(Request $request)
    {
        try {
            $profile = $request->user()->candidateProfile;

            return ResponseHelper::make(
                'success',
                $profile,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'profileImg' => ['nullable', FileRule::image()->max(2048)],
                'firstName' => ['required'],
                'lastName' => ['required'],
                'fatherName' => ['required'],
                'motherName' => ['required'],
                'dob' => ['required', 'date'],
                'address' => ['required', 'min:10'],
                'contact' => ['required', 'digits:10'],
                'emergencyContact' => ['nullable', 'digits:10'],
                'personalWebsite' => ['nullable', 'url'],
                'whatsapp' => ['nullable', 'numeric', 'min:1000000000'],
                'linkedin' => ['nullable', 'url'],
                'github' => ['nullable', 'url'],
                'behance' => ['nullable', 'url'],
                'dribble' => ['nullable', 'url'],
                'twitter' => ['nullable', 'url'],
                'slack' => ['nullable', 'url'],
                'nid' => ['required', 'min:10', 'unique:candidate_profiles,nid'],
                'passport' => ['nullable', 'unique:candidate_profiles,passport'],
                'bloodGroup' => ['required', 'in:A+,A-,AB+,AB-,B+,B-,O+,O-'],
            ]);

            $profileImgUrl = null;

            if ($request->hasFile('profileImg')) {
                $profile = $request->user()->candidateProfile;

                if ($profile and $profile->profileImg !== env('DEFAULT_PROFILE_IMG') and File::exists(public_path($profile->profileImg))) {
                    File::delete(public_path($profile->profileImg));
                }

                $img = $request->file('profileImg');
                $filename = uuid_create() . '.' . $img->getClientOriginalExtension();
                $profileImgUrl = "storage/uploads/profile-images/{$filename}";
                $img->storeAs("uploads/profile-images", $filename);
            }

            $profile = CandidateProfile::updateOrCreate(
                ['user_id' => $request->user()->id],
                [
                    'user_id' => $request->user()->id,
                    'profileImg' => $profileImgUrl,
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'fatherName' => $request->fatherName,
                    'motherName' => $request->motherName,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'contact' => "+880" . $request->contact,
                    'emergencyContact' => $request->emergencyContact ? "+880" . $request->emergencyContact : $request->emergencyContact,
                    'personalWebsite' => $request->personalWebsite,
                    'whatsapp' => $request->whatsapp,
                    'linkedin' => $request->linkedin,
                    'github' => $request->github,
                    'behance' => $request->behance,
                    'dribble' => $request->dribble,
                    'twitter' => $request->twitter,
                    'slack' => $request->slack,
                    'nid' => $request->nid,
                    'passport' => $request->passport,
                    'bloodGroup' => $request->bloodGroup,
                ]
            );

            return ResponseHelper::make(
                'success',
                $profile
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
