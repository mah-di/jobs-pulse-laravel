<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\CompanyPlugin;
use Exception;
use Illuminate\Http\Request;

class CompanyPluginController extends Controller
{
    public function index(Request $request)
    {
        try {
            $q = CompanyPlugin::query();

            if ($request->query('status'))
                $q = $q->where('status', $request->query('status'));

            $data = $q->with(['company', 'plugin'])->paginate(20);

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
            $data = CompanyPlugin::where('company_id', $request->user()->company_id)->with(['plugin'])->get();

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
                'plugin_id' => ['required', 'exists:plugins,id']
            ]);

            CompanyPlugin::updateOrCreate(
                [
                    'company_id' => $request->user()->company_id,
                    'plugin_id' => $request->plugin_id,
                ],
                [
                    'company_id' => $request->user()->company_id,
                    'plugin_id' => $request->plugin_id,
                ]
            );

            return ResponseHelper::make(
                'success',
                null,
                'Plugin requested!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function isActive(Request $request, string $pluginId)
    {
        try {
            $data = CompanyPlugin::where([
                'company_id' => $request->user()->company_id,
                'plugin_id' => $pluginId,
                'status' => 'ACTIVE'
            ])->exists();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function approve(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required']
            ]);

            $data = CompanyPlugin::where('id', $request->id)->update(['status' => 'ACTIVE', 'rejectionFeedback' => null]);

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function reject(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
                'rejectionFeedback' => ['required', 'string']
            ]);

            $data = CompanyPlugin::where('id', $request->id)->update([
                'status' => 'REJECTED',
                'rejectionFeedback' => $request->rejectionFeedback,
            ]);

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'in:ACTIVE,INACTIVE']
            ]);

            $data = CompanyPlugin::where(['id' => $id, 'company_id' => $request->user()->company_id])->whereNotIn('status', ['PENDING', 'REJECTED'])->update(['status' => $request->status]);

            if (!$data)
                throw new Exception("Invalid action");

            return ResponseHelper::make(
                'success',
                null,
                'Plugin status changed to ' . strtolower($request->status) . '!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $data = CompanyPlugin::where('id', $id)->delete();

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
