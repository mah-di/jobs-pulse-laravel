<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Exception;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    public function create(Request $request, string $id)
    {
        try {
            $user = $request->user();

            $user->savedJobs()->syncWithoutDetaching($id);
            $user->save();

            return ResponseHelper::make(
                'success',
                $user,
                'Job Saved!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Request $request, string $jobId)
    {
        try {
            $user = $request->user();

            $user->savedJobs()->detach($jobId);

            return ResponseHelper::make(
                'success',
                $user,
                'Job removed from Saved Jobs!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function deleteAll(Request $request)
    {
        try {
            $user = $request->user();

            $user->savedJobs()->detach();

            return ResponseHelper::make(
                'success',
                $user,
                'Job removed from Saved Jobs!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function showAll(Request $request)
    {
        try {
            $data = $request->user()->savedJobs()->with(['company' => fn($q) => $q->select(['id', 'name'])])->get();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
