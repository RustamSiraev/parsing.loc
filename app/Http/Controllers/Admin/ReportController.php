<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\College;
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
        return view('admin.report.index');
    }

    public function getStatistics(Request $request): JsonResponse
    {
        $arr = College::all()->pluck('id')->toArray();

        if ($request->id) $arr = [$request->id];

        $data = [
            1 => Speciality::whereIn('college_id', $arr)->count() ?? 0,
            2 => Statement::whereIn('speciality_id', Speciality::whereIn('college_id', $arr)->pluck('id')->toArray())->count() ?? 0,
            3 => Statement::whereIn('speciality_id', Speciality::whereIn('college_id', $arr)->pluck('id')->toArray())->where('status_id', 1)->count() ?? 0,
            4 => Statement::whereIn('speciality_id', Speciality::whereIn('college_id', $arr)->pluck('id')->toArray())->where('status_id', 4)->count() ?? 0,
            5 => Statement::whereIn('speciality_id', Speciality::whereIn('college_id', $arr)->pluck('id')->toArray())->where('status_id', 2)->count() ?? 0,
            6 => Statement::whereIn('speciality_id', Speciality::whereIn('college_id', $arr)->pluck('id')->toArray())->where('status_id', 3)->count() ?? 0,
            7 => Statement::whereIn('speciality_id', Speciality::whereIn('college_id', $arr)->pluck('id')->toArray())->where('status_id', 5)->count() ?? 0,
        ];

        return response()->json($data);
    }
}
