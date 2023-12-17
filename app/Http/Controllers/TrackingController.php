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

class TrackingController extends Controller
{
    public function track_complaints(Request $request)
    {
        $tracking_id = $request->id;
        $complaints = Complaint::where('complaint_id', $tracking_id)->get();
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
                'complain_status' =>  $complaint->complain_status,
                'institution' => $institution,
                'description' => $complaint->description,
                'timeframe' => $timeframe,
                'reported_by' => $reported_by->first_name . ' ' . $reported_by->last_name,
            ];
        });
        $tracking = ComplaintStatus::where('complaint_id', $tracking_id)->orderBy('status', 'asc')->get();
        $tracking->transform(function ($trac) {
            return [
                'complaint_id' => $trac->complaint_id,
                'status' => $trac->status,
                'officer_id' =>  $trac->officer_id,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $trac->created_at)->format('D, M d'),
            ];
        });
        // dd($tracking);
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "Track Complaint"]
        ];
        return view('/pages/track-complaint', [
            'breadcrumbs' => $breadcrumbs,
            'complaint' => $complaints[0],
            'tracking_details' => $tracking,
        ]);
    }

    public function save_track_complaints(Request $request)
    {
        $complain_id = $request->complain_id;
        $complain_status = $request->complain_status;
        $comment = $request->comment;
        DB::beginTransaction();
        try {
            // dd($complain_status);
            Complaint::where('complaint_id', $complain_id)->update([
                'complain_status' => $complain_status
            ]);
            ComplaintStatus::create([
                'complaint_id' => $complain_id,
                'status' => $complain_status,
                'comment' => $comment,
                'officer_id' =>  1,
            ]);
            AuditLog::create([
                'u_id' => 1,
                'section_name' => 'Update Tracking',
                'action' => 'Tracking update',
                'previous_records' => '',
                'new_records' => 'Complaint Status : ' . $complain_status . ' Comment : ' . $comment
            ]);
            DB::commit();
            return back()->with('success', 'Tracking updated in successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e->getMessage());
            AuditLog::create([
                'u_id' => 1,
                'section_name' => 'Update Tracking',
                'action' => 'Tracking update',
                'previous_records' => '',
                'new_records' => 'Complaint Status : ' . $complain_status . ' Comment : ' . $comment
            ]);
            return  back()->with('error', $e->getMessage());
        }
    }
}
