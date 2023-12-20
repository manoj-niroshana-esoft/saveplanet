<?php

namespace App\Http\Controllers;

use App\Division;
use App\Institution;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use App\User;
use Carbon\Carbon;

class DivisionController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth_verify');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "Manage Division"]
        ];
        $divisions = Division::orderBy('division_id', 'desc')->get();
        $divisions->transform(function ($division) {
            $institution = Institution::where('institution_id', $division->institution_id)->first();
            return [
                'division_id' => $division->division_id,
                'institution' => $institution->name,
                'name' => $division->name,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $division->created_at)->format('Y-m-d H:i:s'),
            ];
        });

        return view('pages.view-division', compact(['divisions', 'breadcrumbs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['link' => "manage-division", 'name' => "Manage Division"], ['name' => "Create Division"]
        ];
        $institutions = Institution::all();
        return view('pages.create-division', compact(['breadcrumbs', 'institutions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Division::create([
            'name' => $request->division_name,
            'institution_id' => $request->institution_id
        ]);

        return redirect('/manage-division')->with('success', 'Division Saved Success.');
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
        $division = Division::find($id);
        $institutions = Institution::all();
        return view('pages.edit-division', compact(['division', 'institutions']));
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
    public function update_division(Request $request)
    {
        $division = Division::find($request->id);
        $division->name = $request->input('division_name');
        $division->institution_id = $request->input('institution_id');
        $division->save();

        return redirect('/manage-division')->with('success', 'Division Saved Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $division = Division::find($id);
        $division->delete();
        return redirect('/manage-division')->with('success', 'Division Removed Success');
    }
}
