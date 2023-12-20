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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Branch::create([
            'name' => $request->branch_name,
            'division_id' => $request->division_id
        ]);

        return redirect('/manage-branch')->with('success', 'Branch Saved Success.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);
        $divisions = Division::all();
        return view('pages.edit-branch', compact(['branch', 'divisions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }
    public function update_branch(Request $request)
    {
        $branch = Branch::find($request->id);
        $branch->name = $request->input('branch_name');
        $branch->division_id = $request->input('division_id');
        $branch->save();

        return redirect('/manage-branch')->with('success', 'Branch Saved Success');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return redirect('/manage-branch')->with('success', 'Branch Removed Success');
    }
}