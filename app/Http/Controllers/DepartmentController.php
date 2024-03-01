<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $data = Department::pluck('name');

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'name' =>['required', 'string'],
            ]);

            $data = Department::updateOrCreate(
                ['name' => $request->name],
                ['name' => $request->name]
            );

            return ResponseHelper::make(
                'success',
                $data,
                'Department saved!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(string $name)
    {
        try {
            $data = Department::where('name', $name)->delete();

            return ResponseHelper::make(
                'success',
                $data,
                'Department deleted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
