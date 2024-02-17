<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
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
            $user = $request->user();
            $user->profile;

            return ResponseHelper::make(
                'success',
                $user,
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
                ImageHelper::delete($profile->profileImg);

                $imgUrl = ImageHelper::save($request->file('profileImg'), 'profile-images');

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
