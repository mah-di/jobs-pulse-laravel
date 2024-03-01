<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\JobCategory;
use Exception;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'unique:job_categories']
            ]);

            $data = JobCategory::create([
                'name' => $request->name
            ]);

            return ResponseHelper::make(
                'success',
                $data,
                "Job Category created!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => ['required', 'unique:job_categories,name,' . $id]
            ]);

            $data = JobCategory::where('id', $id)->update(['name' => $request->name]);

            return ResponseHelper::make(
                'success',
                $data,
                'Job category updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
    public function index(Request $request)
    {
        try {
            $data = JobCategory::all();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
    public function show(Request $request, string $id)
    {
        try {
            $data = JobCategory::find($id);

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
            $data = JobCategory::where('id', $id)->delete();

            return ResponseHelper::make(
                'success',
                $data,
                'Job category deleted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
