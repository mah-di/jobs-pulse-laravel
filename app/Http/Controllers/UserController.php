<?php

namespace App\Http\Controllers;

use App\Helpers\JWTHelper;
use App\Helpers\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\Company;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File as FileRule;

class UserController extends Controller
{
    public function registerCompany(Request $request)
    {
        try {
            $request->validate([
                'comName' => ['required', 'min:3'],
                'comLogo' => ['required', FileRule::image()->max(2048)],
                'comDescription' => ['required', 'min:50'],
                'comAddress' => ['required', 'min:10'],
                'comContact' => ['required', 'digits_between:11,15', 'unique:companies,contact'],
                'comEmail' => ['required', 'email', 'unique:companies,email'],
                'comWebsite' => ['nullable', 'url', 'unique:companies,website'],
                'comEstablishDate' => ['required', 'date'],
                'userEmail' => ['required', 'email', 'unique:users,email'],
                'userPassword' => ['required'],
                'userFirstName' => ['required'],
                'userLastName' => ['required'],
                'userProfileImg' => ['nullable', FileRule::image()->max(2048)],
            ]);

            if ($request->hasFile('comLogo')) {
                $logo = $request->file('comLogo');
                $filename = uuid_create() . '.' . $logo->getClientOriginalExtension();
                $logoUrl = "storage/uploads/company-logos/{$filename}";
                $logo->storeAs("uploads/company-logos", $filename);
            }

            $profileImgUrl = null;

            if ($request->hasFile('userProfileImg')) {
                $profileImg = $request->file('userProfileImg');
                $filename = uuid_create() . '.' . $profileImg->getClientOriginalExtension();
                $profileImgUrl = "storage/uploads/profile-images/{$filename}";
                $profileImg->storeAs("uploads/profile-images", $filename);
            }

            DB::beginTransaction();

            $company = Company::create([
                'name' => $request->comName,
                'logo' => $logoUrl,
                'description' => $request->comDescription,
                'address' => $request->comAddress,
                'contact' => $request->comContact,
                'email' => $request->comEmail,
                'website' => $request->comWebsite,
                'establishDate' => $request->comEstablishDate,
                'status' => 'pending',
            ]);

            $otp = rand(100000, 999999);

            $user = User::create([
                'company_id' => $company->id,
                'email' => $request->userEmail,
                'role' => 'admin',
                'password' => $request->userPassword,
                'otp' => $otp,
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'firstName' => $request->userFirstName,
                'lastName' => $request->userLastName,
                'profileImg' => $profileImgUrl,
            ]);

            DB::commit();

            Mail::to($user->email)->send(new OTPMail($otp));

            $token = JWTHelper::createToken($user);

            return ResponseHelper::make(
                'success',
                compact('company', 'user', 'profile'),
                'Registration Successful! 6 digit verification OTP has been sent to your email.',
                ['token' => $token]
            )->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function registerCandidate(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required'],
            ]);

            $otp = rand(100000, 999999);

            $user = User::create([
                'company_id' => null,
                'email' => $request->email,
                'role' => 'candidate',
                'password' => $request->password,
                'otp' => $otp,
            ]);

            Mail::to($user->email)->send(new OTPMail($otp));

            $token = JWTHelper::createToken($user);

            return ResponseHelper::make(
                'success',
                $user,
                'Registration Successful! 6 digit verification OTP has been sent to your email.',
                ['token' => $token]
            )->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function loginSuperUser(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::whereNull('company_id')->where('isSuperUser', true)->where('email', $request->email)->first();

            if (!$user or !Hash::check($request->password, $user->password))
                throw new Exception("Invalid credentials.");

            $token = JWTHelper::createToken($user);

            return ResponseHelper::make(
                'success',
                null,
                'Login successful!',
                ['token' => $token]
            )->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function loginCompany(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::whereNotNull('company_id')->where('isSuperUser', false)->where('email', $request->email)->first();

            if (!$user or !Hash::check($request->password, $user->password))
                throw new Exception("Invalid credentials.");

            $token = JWTHelper::createToken($user);

            return ResponseHelper::make(
                'success',
                null,
                'Login successful!',
                ['token' => $token]
            )->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function loginCandidate(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::whereNull('company_id')->where('isSuperUser', false)->where('email', $request->email)->first();

            if (!$user or !Hash::check($request->password, $user->password))
                throw new Exception("Invalid credentials.");

            $token = JWTHelper::createToken($user);

            return ResponseHelper::make(
                'success',
                null,
                'Login successful!',
                ['token' => $token]
            )->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function verifyEmail(Request $request)
    {
        try {
            $request->validate([
                'otp' => ['required', 'numeric', 'digits:6']
            ]);

            $user = $request->user();

            if ($user->otp !== $request->otp)
                throw new Exception("Invalid OTP");

            $user->update([
                'otp' => 0,
                'emailVerifiedAt' => now(),
            ]);

            $token = JWTHelper::createToken($user);

            return ResponseHelper::make(
                'success',
                null,
                'Email verification successful!',
                ['token' => $token]
            )->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function logout()
    {
        return Redirect::route('login.view')->cookie('token', '', -1);
    }
}
