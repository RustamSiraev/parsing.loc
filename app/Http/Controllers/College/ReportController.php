<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\AdminController;
use App\Models\Speciality;
use App\Models\Statement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends AdminController
{
    public function index(): View|Factory|Application
    {
        return view('college.report.index');
    }

    public function getStatistics(Request $request): JsonResponse
    {
        $arr = Speciality::where('college_id', auth()->user()->college_id)->pluck('id')->toArray();

        if ($request->id) $arr = [$request->id];

        $data = [
            1 => Statement::whereIn('speciality_id', $arr)->count() ?? 0,
            2 => Statement::whereIn('speciality_id', $arr)->where('status_id', 1)->count() ?? 0,
            3 => Statement::whereIn('speciality_id', $arr)->where('status_id', 4)->count() ?? 0,
            4 => Statement::whereIn('speciality_id', $arr)->where('status_id', 2)->count() ?? 0,
            5 => Statement::whereIn('speciality_id', $arr)->where('status_id', 3)->count() ?? 0,
            6 => Statement::whereIn('speciality_id', $arr)->where('status_id', 5)->count() ?? 0,
        ];

        return response()->json($data);
    }
}
