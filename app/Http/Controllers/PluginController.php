<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Plugin;
use Exception;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    public function index()
    {
        try {
            $data = Plugin::all();

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
                'id' => ['required', 'exists:plugins'],
                'title' => ['required', 'string']
            ]);

            Plugin::where('id', $request->id)->update(['title' => $request->title]);

            return ResponseHelper::make(
                'success',
                null,
                'Plugin title updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
