<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\EnquiryResource;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request, DashboardService $dashboard): Response
    {
        $user = $request->user();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $dashboard->statsFor($user),
            'brands' => BrandResource::collection($dashboard->brandBreakdownFor($user)),
            'latestEnquiries' => EnquiryResource::collection($dashboard->latestEnquiriesFor($user)),
        ]);
    }
}
