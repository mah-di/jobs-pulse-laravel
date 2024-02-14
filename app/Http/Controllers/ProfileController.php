<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        try {
            $profile = $request->user()->profile;

            return ResponseHelper::make(
                'success',
                $profile,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'firstName' => ['required'],
                'lastName' => ['required'],
                'profileImg' => ['nullable', FileRule::image()->max(2048)],
            ]);

            $profile = $request->user()->profile;

            if ($request->hasFile('profileImg')) {
                if ($profile->profileImg !== env('DEFAULT_PROFILE_IMG') and File::exists(public_path($profile->profileImg)))
                    File::delete(public_path($profile->profileImg));

                $img = $request->file('profileImg');
                $filename = uuid_create() . '.' . $img->getClientOriginalExtension();
                $imgUrl = "storage/uploads/profile-images/{$filename}";
                $img->storeAs('uploads/profile-images', $filename);

                $profile->profileImg = $imgUrl;
            }

            $profile->firstName = $request->firstName;
            $profile->lastName = $request->lastName;

            $profile->save();

            return ResponseHelper::make(
                'success',
                $profile,
                'Profile updated!',
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
