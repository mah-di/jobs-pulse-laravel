<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $q = User::query();

            if ($request->query('role'))
                $q = $q->where('role', $request->query('role'));

            $data = $q->with('profile')->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByCompany(Request $request)
    {
        try {
            $q = User::where('company_id', $request->user()->company_id);

            if ($request->query('role'))
                $q = $q->where('role', $request->query('role'));

            $data = $q->with('profile')->get();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string'],
                'firstName' => ['required', 'string'],
                'lastName' => ['required', 'string'],
            ]);

            if ($request->user()->isSuperUser)
                $request->validate(['role' => ['required', 'in:Site Admin,Site Manager,Site Editor']]);
            else
                $request->validate(['role' => ['required', 'in:Admin,Manager,Editor']]);

            DB::beginTransaction();

            $otp = rand(100000, 999999);

            $user = User::create([
                'company_id' => $request->user()->company_id,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
                'isSuperUser' => $request->user()->isSuperUser,
                'otp' => $otp
            ]);

            Profile::create([
                'user_id' => $user->id,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'profileImg' => env('DEFAULT_PROFILE_IMG'),
            ]);

            DB::commit();

            Mail::to($request->email)->send(new OTPMail($otp));

            return ResponseHelper::make(
                'success',
                null,
                'Employee created!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function assignRole(Request $request, string $id)
    {
        try {
            if ($request->user()->isSuperUser)
                $request->validate(['role' => ['required', 'in:Site Admin,Site Manager,Site Editor']]);
            else
                $request->validate(['role' => ['required', 'in:Admin,Manager,Editor']]);

            $data = User::where(['id' => $id, 'company_id' => $request->user()->company_id])->update(['role' => $request->role]);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            $data = User::where(['id' => $id, 'company_id' => $request->user()->company_id])->whereNotIn('role', ['Site Admin', 'Admin'])->delete();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
