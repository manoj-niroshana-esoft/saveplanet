<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Complaint;
use App\ComplaintDetail;
use App\ComplaintStatus;
use App\Institution;
use App\Officer;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class ComplaintController extends Controller
{
    // Form Wizard
    public function complaint()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "New Complaint"]
        ];
        return view('/pages/form-complaint', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function view_complaint()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "View Complaint"]
        ];
        $complaints = Complaint::orderBy('complaint_id', 'desc')->get();
        $complaints->transform(function ($complaint) {
            switch ($complaint->complain_type) {
                case '1':
                    $complain_type = 'Wildlife';
                    break;
                case '2':
                    $complain_type = 'Forestry';
                    break;
                case '3':
                    $complain_type = 'Environment Crime';
                    break;
            }
            $institution = Institution::where('institution_id', $complaint->institution_id)->first()->name;
            $reported_by = User::where('u_id', $complaint->u_id)->first(['first_name', 'last_name']);
            $timeframe = 'From : ' . $complaint->from_date;
            if ($complaint->from_time != null) {
                $timeframe .= ' ' . $complaint->from_time;
            }
            if ($complaint->to_date != null) {
                $timeframe .=   ' To : ' . Carbon::createFromFormat('Y-m-d H:i:s', $complaint->to_date)->format('Y-m-d');
            }
            if ($complaint->to_time != null) {
                $timeframe .=   ' ' . $complaint->to_time;
            }
            $complaint_status = ComplaintStatus::where([['complaint_id', $complaint->complaint_id], ['status', 2]])->first();
            // dd($complaint_status);
            return [
                'complaint_id' => $complaint->complaint_id,
                'complain_type' => $complain_type,
                'institution' => $institution,
                'description' => $complaint->description,
                'timeframe' => $timeframe,
                'officer_id' => $complaint_status != null ? $complaint_status->officer_id : '',
                'reported_by' => $reported_by->first_name . ' ' . $reported_by->last_name,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $complaint->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => $complaint->updated_at != null ? Carbon::createFromFormat('Y-m-d H:i:s', $complaint->updated_at)->format('Y-m-d H:i:s') : '-',
            ];
        });
        $officers =  DB::table('officer')
            ->join('branch', 'branch.branch_id', '=', 'officer.branch_id')
            ->join('division', 'division.division_id', '=', 'branch.division_id')
            ->join('institution', 'institution.institution_id', '=', 'division.institution_id')
            ->get(['officer.officer_id', 'officer.name', 'division.name as division_name', 'branch.name as branch_name', 'institution.name as institution_name']);
        return view('/pages/view-complaint', [
            'breadcrumbs' => $breadcrumbs,
            'complaints' => $complaints,
            'officers' => $officers,
        ]);
    }

    public function save_assigned_officer(Request $request)
    {
        $complain_id = $request->complaint_id;
        $officer_id = $request->officer_id;
        DB::beginTransaction();
        try {
            DB::table('officer')
                ->where('officer.officer_id', $officer_id)
                ->update(['availability' => 0, 'current_complaint_id' => $complain_id]);
            Complaint::where('complaint_id', $complain_id)->update([
                'complain_status' => 2
            ]);
            $complaint_status =  ComplaintStatus::where([
                ['complaint_id', '=',  $complain_id],
                ['status', '=',  2],
            ])->get();
            if ($complaint_status->count() > 0) {
                $complaint_status_officer =  ComplaintStatus::where([
                    ['status', '!=',  4],
                    ['officer_id', '=',  $officer_id],
                ])->get();
                if ($complaint_status_officer->count() > 0) {
                    return back()->with('error', 'The officer has already assigned the job!');
                } else {
                    $complaint_status_previous_officer =  ComplaintStatus::where([
                        ['status', '=', 2],
                        ['complaint_id', '=',  $complain_id],
                    ])->first();
                    Officer::where('officer_id', $complaint_status_previous_officer->officer_id)->update([
                        'current_complaint_id' => null,
                        'availability' => 1,
                    ]);
                    ComplaintStatus::where([
                        ['complaint_id', '=',  $complain_id],
                        ['status', '=',  2],
                    ])->update([
                        'complaint_id' => $complain_id,
                        'status' => 2,
                        'comment' => 'Manually Assigned Officer',
                        'officer_id' =>  $officer_id,
                    ]);
                    DB::commit();
                    return back()->with('success', 'Officer reassigned in successfully!');
                }
            } else {
                ComplaintStatus::create([
                    'complaint_id' => $complain_id,
                    'status' => 2,
                    'comment' => 'Manually Assigned Officer',
                    'officer_id' =>  $officer_id,
                ]);
                DB::commit();
                return back()->with('success', 'Officer assigned in successfully!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e->getMessage());
            return  back()->with('error', $e->getMessage());
        }
    }

    public function new_complaint(Request $request)
    {
        DB::beginTransaction();

        try {
            switch ($request->complain_type) {
                case 'wildlife':
                    $institution_id = 1;
                    $complain_type = 1;
                    break;
                case 'forestry':
                    $institution_id = 1;
                    $complain_type = 2;
                    break;
                case 'env_crime':
                    $institution_id = 2;
                    $complain_type = 3;
                    break;
            }
            $complaint = Complaint::insertGetId([
                'u_id' => 1,
                'complain_type' => $complain_type,
                'complain_status' => 1,
                'institution_id' => $institution_id,
                'description' =>  $request->shortDescription,
                'latitude' =>  $request->lat,
                'longitude' =>  $request->lon,
                'from_date' =>  $request->from_date,
                'from_time' =>  $request->from_time,
                'to_date' =>  $request->to_date,
                'to_time' =>  $request->to_time,
                'created_at' =>  now(),
                'updated_at' =>  now(),
            ]);
            ComplaintStatus::create([
                'complaint_id' => $complaint,
                'status' => 1,
                'comment' => 'Complain Recorded',
            ]);
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $image) {
                    // $name = $image->getClientOriginalName();
                    // $image->move(public_path() . '/image/', $name);
                    // $data[] = $name;
                    $filenameWithExt = $image->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $image->storeAs('public/img', $fileNameToStore);
                    ComplaintDetail::create([
                        'complaint_id' => $complaint,
                        'picture_of_evidence' => 'img/' . $fileNameToStore,
                    ]);
                }
            }
            $officer =  DB::table('officer')
                ->join('branch', 'branch.branch_id', '=', 'officer.branch_id')
                ->join('division', 'division.division_id', '=', 'branch.division_id')
                ->join('institution', 'institution.institution_id', '=', 'division.institution_id')
                ->where('institution.institution_id', $institution_id)
                ->where('officer.availability', 1)
                ->whereNull('officer.current_complaint_id')
                ->limit(1)->first();
            if ($officer) {
                DB::table('officer')
                    ->where('officer.officer_id', $officer->officer_id)
                    ->update(['availability' => 0, 'current_complaint_id' => $complaint]);
                Complaint::where('complaint_id', $complaint)->update([
                    'complain_status' => 2
                ]);
                ComplaintStatus::create([
                    'complaint_id' => $complaint,
                    'status' => 2,
                    'comment' => 'Automatically Assigned Officer',
                    'officer_id' =>  $officer->officer_id,
                ]);
            }
            DB::commit();
            return redirect('view-complaint')->with('success', 'Complaint Created in successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            AuditLog::create([
                'u_id' => 1,
                'section_name' => 'New Complain',
                'action' => 'Add New Complaint - Error',
                'previous_records' => '',
                'new_records' => 'Complaint Type : ' . $complain_type . ' Complaint : ' . $request->shortDescription
            ]);
            Log::critical($e->getMessage());
            return redirect('complaint')->with('error', $e->getMessage());
        }
    }

    public function view_complaint_details(Request $request)
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['link' => "view-complaint", 'name' => "View Complaints"], ['name' => "View Complaint Details"]
        ];
        $tracking_id = $request->id;
        $complaints = Complaint::where('complaint_id', $tracking_id)->get();
        $complaints->transform(function ($complaint) {
            $complaint_details = ComplaintDetail::where('complaint_id', $complaint->complaint_id)->get('picture_of_evidence');
            return [
                'complaint_id' => $complaint->complaint_id,
                'longitude' => $complaint->longitude,
                'latitude' => $complaint->latitude,
                'complaint_details' => $complaint_details,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $complaint->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => $complaint->updated_at != null ? Carbon::createFromFormat('Y-m-d H:i:s', $complaint->updated_at)->format('Y-m-d H:i:s') : '-',
            ];
        });
        // dd($complaints[0]);
        return view('/pages/view-complaint-details', [
            'breadcrumbs' => $breadcrumbs,
            'complaints' => $complaints[0],
        ]);
    }
}
