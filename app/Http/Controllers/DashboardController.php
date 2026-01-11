<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdmissionQuery;

class DashboardController extends Controller
{
    public function index()
    {
        // Example: Get admission queries for dashboard
        $queries = AdmissionQuery::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', [
            'queries' => $queries,
            'pendingCount' => AdmissionQuery::where('status', 'pending')->count(),
            'totalCount' => AdmissionQuery::count(),
        ]);
    }
}
