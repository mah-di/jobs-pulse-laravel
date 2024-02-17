<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $data = Role::where('type', $request->query('type'))->pluck('title');

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
