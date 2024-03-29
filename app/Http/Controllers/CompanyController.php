<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class CompanyController extends Controller
{
    public function topCompanies()
    {
        try {
            $data = Company::select(['id', 'name', 'logo'])->orderByDesc('jobsPosted')->take(6)->get();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function index(string $status)
    {
        try {
            $data = Company::where('status', $status)->paginate(20);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = Company::find($id);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required'],
                'logo' => ['nullable', FileRule::image()->max(2048)],
                'logoUrl' => ['required'],
                'description' => ['required'],
                'address' => ['required'],
                'contact' => ['required', 'digits:10'],
                'email' => ['required', 'email', 'unique:companies,email,' . $request->user()->company_id],
                'website' => ['nullable', 'url', 'unique:companies,website,' . $request->user()->company_id],
                'establishDate' => ['required', 'date'],
            ]);

            $logoUrl = $request->logoUrl;

            if ($request->hasFile('logo')) {
                ImageHelper::delete($logoUrl);

                $logoUrl = ImageHelper::save($request->file('logo'), 'company-logos');
            }

            Company::where('id', $request->user()->company_id)->update([
                'name' => $request->name,
                'logo' => $logoUrl,
                'description' => $request->description,
                'address' => $request->address,
                'contact' => $request->contact,
                'email' => $request->email,
                'website' => $request->website,
                'establishDate' => $request->establishDate,
            ]);

            return ResponseHelper::make(
                'success',
                null,
                'Company info updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function isActive(Request $request)
    {
        try {
            $data = $request->user()->company()->where('status', 'ACTIVE')->exists();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function adminOverview()
    {
        try {
            $pendingCompanies = Company::where('status', 'PENDING')->count();
            $activeCompanies = Company::where('status', 'ACTIVE')->count();
            $restrictedCompanies = Company::where('status', 'RESTRICTED')->count();
            $pendingJobs = Job::where('status', 'PENDING')->count();
            $availableJobs = Job::where('status', 'AVAILABLE')->count();
            $siteAdmins = User::where('role', 'Site Admin')->count();
            $siteManagers = User::where('role', 'Site Manager')->count();
            $siteEditors = User::where('role', 'Site Editor')->count();

            return ResponseHelper::make(
                'success',
                compact(['pendingCompanies', 'activeCompanies', 'restrictedCompanies', 'pendingJobs', 'availableJobs', 'siteAdmins', 'siteManagers', 'siteEditors'])
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function companyOverview(Request $request)
    {
        try {
            $posted = $request->user()->company->jobs()->count();
            $pending = $request->user()->company->jobs()->where('status', 'PENDING')->count();
            $restricted = $request->user()->company->jobs()->where('status', 'RESTRICTED')->count();
            $unavailable = $request->user()->company->jobs()->where('status', 'UNAVAILABLE')->count();
            $available = $request->user()->company->jobsPosted;
            $employees = $request->user()->company->employees()->count();

            return ResponseHelper::make(
                'success',
                compact(['posted', 'pending', 'available', 'unavailable', 'restricted', 'employees'])
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function updateActivity(Request $request, Company $company)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:ACTIVE,INACTIVE']
            ]);

            $company->update(['status' => $request->status]);

            return ResponseHelper::make(
                'success',
                null,
                'Company status set to ' . strtolower($request->status)
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function approve(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
            ]);

            Company::where('id', $request->id)->update(['status' => 'ACTIVE', 'restrictionFeedback' => null]);

            return ResponseHelper::make(
                'success',
                null,
                'Company has been approved!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function restrict(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
                'restrictionFeedback' => ['required']
            ]);

            Company::where('id', $request->id)->update([
                'status' => 'RESTRICTED',
                'restrictionFeedback' => $request->restrictionFeedback
            ]);

            return ResponseHelper::make(
                'success',
                null,
                'Company has been restricted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
