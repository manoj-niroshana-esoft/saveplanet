<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Complaint;
use App\ComplaintDetail;
use App\ComplaintStatus;
use App\Institution;
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
        $complaints = Complaint::all();
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
            return [
                'complaint_id' => $complaint->complaint_id,
                'complain_type' => $complain_type,
                'institution' => $institution,
                'description' => $complaint->description,
                'timeframe' => $timeframe,
                'reported_by' => $reported_by->first_name . ' ' . $reported_by->last_name,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $complaint->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => $complaint->updated_at != null ? Carbon::createFromFormat('Y-m-d H:i:s', $complaint->updated_at)->format('Y-m-d H:i:s') : '-',
            ];
        });
        // dd($complaints[0]);
        return view('/pages/view-complaint', [
            'breadcrumbs' => $breadcrumbs,
            'complaints' => $complaints,
        ]);
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
                    $path = $image->storeAs('public/cv', $fileNameToStore);
                    ComplaintDetail::create([
                        'complaint_id' => $complaint,
                        'picture_of_evidence' => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect('view-complaint')->with('success', 'Complaint Created in successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            AuditLog::create([
                'u_id' => 1,
                'section_name' => 'New Complain',
                'action' => 'Add New Complaint',
                'previous_records' => '',
                'new_records' => 'Complaint Type : ' . $complain_type . ' Complaint : ' . $request->shortDescription
            ]);
            Log::critical($e->getMessage());
            return redirect('complaint')->with('error', $e->getMessage());
        }
    }

    
}
