<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(Request $request, string $companyId)
    {
        try {
            $data = BlogCategory::where('company_id', $companyId)->get();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'id' => ['nullable'],
                'name' => ['required'],
            ]);

            $data = BlogCategory::updateOrCreate(
                [
                    'id' => $request->id,
                    'company_id' => $request->user()->company_id,
                ],
                [
                    'company_id' => $request->user()->company_id,
                    'name' => $request->name,
                ]
            );

            return ResponseHelper::make(
                'success',
                $data,
                'Blog Category saved!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = BlogCategory::find($id);

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(BlogCategory $category)
    {
        try {
            $category->delete();

            return ResponseHelper::make(
                'success',
                null,
                'Blog Category deleted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
