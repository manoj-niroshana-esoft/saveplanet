<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Division;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use App\User;
use Carbon\Carbon;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "Manage Branch"]
        ];
        $branches = Branch::orderBy('branch_id', 'desc')->get();
        $branches->transform(function ($branch) {
            $division = Division::where('division_id', $branch->division_id)->first();
            return [
                'branch_id' => $branch->branch_id,
                'division' => $division->name,
                'name' => $branch->name,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $branch->created_at)->format('Y-m-d H:i:s'),
            ];
        });

        return view('pages.view-branch', compact(['branches', 'breadcrumbs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['link' => "manage-division", 'name' => "Manage Branch"], ['name' => "Create Branch"]
        ];
        $divisions = Division::all();
        return view('pages.create-branch', compact(['breadcrumbs', 'divisions']));
    }
}