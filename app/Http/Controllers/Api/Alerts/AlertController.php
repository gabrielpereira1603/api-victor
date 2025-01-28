<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Models\Alert;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AlertController
{
    public function findAll(): JsonResponse
    {
        $today = Carbon::today();

        $activeAlerts = Alert::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereNull('deleted_at')
            ->get();

        $expiredAlerts = Alert::withTrashed()
            ->where(function ($query) use ($today) {
                $query->where('end_date', '<', $today)
                    ->orWhereNotNull('deleted_at');
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'activeAlerts' => $activeAlerts,
                'expiredAlerts' => $expiredAlerts,
            ],
        ]);
    }
}
