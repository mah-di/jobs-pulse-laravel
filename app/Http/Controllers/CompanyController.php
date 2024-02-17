<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class CompanyController extends Controller
{
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

    public function updateActivity(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:ACTIVE,INACTIVE']
            ]);

            if (!$request->user()->isSuperUper and ($request->user()->company_id != $id or $request->user()->company()->whereIn('status', ['PENDING', 'RESTRICTED'])->exists()))
                throw new Exception("Unauthorized request");

            Company::where('id', $id)->update(['status' => $request->status]);

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

            Company::where('id', $request->id)->update(['status' => 'ACTIVE']);

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
