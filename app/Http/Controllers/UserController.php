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
                'comContact' => ['required', 'digits:10', 'unique:companies,contact'],
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

            $profileImgUrl = env('DEFAULT_PROFILE_IMG');

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
                'contact' => '+880' . $request->comContact,
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

            if (time() - $user->updated_at->getTimestamp() > 300) {
                $user->update(['otp' => 0]);
                throw new Exception("OTP expired");
            }

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

    public function resendVerificationOTP(Request $request)
    {
        try {
            $otp = rand(100000, 999999);

            $user = $request->user();
            $user->update(['otp' => $otp]);

            Mail::to($user->email)->send(new OTPMail($otp));

            return ResponseHelper::make(
                'success',
                null,
                '6 digit verification OTP has been sent to your email!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function sendPasswordResetOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email']
            ]);

            $otp = rand(100000, 999999);

            $user = User::where('email', $request->email)->update(['otp' => $otp]);

            if (!$user)
                throw new Exception("This email isn't registered in our system.");

            Mail::to($request->email)->send(new OTPMail($otp, 'password.reset'));

            return ResponseHelper::make(
                'success',
                null,
                '6 digit password reset OTP has been sent to your email!',
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function verifyPasswordResetOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'otp' => ['required', 'numeric', 'digits:6'],
            ]);

            $user = User::where(['email' => $request->email, 'otp' => $request->otp])->first();

            if (!$user)
                throw new Exception("Invalid credentials");

            if (time() - $user->updated_at->getTimestamp() > 300) {
                $user->update(['otp' => 0]);
                throw new Exception("OTP expired");
            }

            $user->otp = 0;
            if (!$user->emailVerifiedAt) $user->emailVerifiedAt = now();

            $user->save();

            $token = JWTHelper::createToken($user, 'password.reset');

            return ResponseHelper::make(
                'success',
                null,
                'OTP verified!',
                ['token' => $token]
            )->cookie('token', $token, 10);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required']
            ]);

            $request->user()->update(['password' => $request->password]);

            return ResponseHelper::make(
                'success',
                null,
                'Password Reset Successful!',
            )->cookie('token', '', -1);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required'],
                'newPassword' => ['required'],
            ]);

            if (!Hash::check($request->password, $request->user()->password))
                throw new Exception("Incorrect Password");

            $request->user()->update(['password' => $request->newPassword]);

            return ResponseHelper::make(
                'success',
                null,
                'Password Changed Successfully!',
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function logout()
    {
        return Redirect::route('login.view')->cookie('token', '', -1);
    }
}
