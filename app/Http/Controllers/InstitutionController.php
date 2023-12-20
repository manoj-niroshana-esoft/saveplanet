<?php

namespace App\Http\Controllers;

use App\Institution;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use App\User;
use Carbon\Carbon;

class InstitutionController extends Controller
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
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "Manage Institution"]
        ];
        $institutions = Institution::orderBy('institution_id', 'desc')->get();
        $institutions->transform(function ($institution) {
            return [
                'institution_id' => $institution->institution_id,
                'name' => $institution->name,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $institution->created_at)->format('Y-m-d H:i:s'),
            ];
        });
        return view('pages.view-institution', compact(['institutions', 'breadcrumbs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['link' => "manage-institution", 'name' => "Manage Institution"], ['name' => "Create Institution"]
        ];
        return view('pages.create-institution', compact(['breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Institution::create([
            'name' => $request->institution_name
        ]);

        return redirect('/manage-institution')->with('success', 'Institution Saved Success.');
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
        $institution = Institution::find($id);
        return view('pages.edit-institution', compact(['institution']));
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
        dd($id);
        $institution = Institution::find($id);
        $institution->name = $request->input('institution_name');
        $institution->save();

        return redirect('/manage-institution')->with('success', 'Institution Saved Success');
    }
    public function update_institution(Request $request)
    {
        $institution = Institution::find($request->id);
        $institution->name = $request->input('institution_name');
        $institution->save();

        return redirect('/manage-institution')->with('success', 'Institution Saved Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::find($id);
        $institution->delete();
        return redirect('/manage-institution')->with('success', 'Institution Removed Success');
    }
}
