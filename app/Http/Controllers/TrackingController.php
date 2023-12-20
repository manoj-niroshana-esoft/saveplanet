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

class TrackingController extends Controller
{
  
   

    public function save_track_complaints(Request $request)
    {
        $complain_id = $request->complain_id;
        $complain_status = $request->complain_status;
        $comment = $request->comment;
        DB::beginTransaction();
        try {
            $complaint_exists = Complaint::where('complaint_id', $complain_id)->where('complain_status', 2)->first();
            if (!$complaint_exists) {
                return back()->with('error', 'Please assign offcer before change the status !');
            } else {
                Complaint::where('complaint_id', $complain_id)->update([
                    'complain_status' => $complain_status
                ]);
                ComplaintStatus::create([
                    'complaint_id' => $complain_id,
                    'status' => $complain_status,
                    'comment' => $comment,
                    'officer_id' =>  $request->session()->get('officer_id'),
                ]);
                AuditLog::create([
                    'u_id' => $request->session()->get('u_id'),
                    'section_name' => 'Update Tracking',
                    'action' => 'Tracking update',
                    'previous_records' => '',
                    'new_records' => 'Complaint Status : ' . $complain_status . ' Comment : ' . $comment
                ]);
                DB::commit();
                return back()->with('success', 'Tracking updated in successfully!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e->getMessage());
            AuditLog::create([
                'u_id' => 1,
                'section_name' => 'Update Tracking',
                'action' => 'Tracking update - Error',
                'previous_records' => '',
                'new_records' => 'Complaint Status : ' . $complain_status . ' Comment : ' . $comment
            ]);
            return  back()->with('error', $e->getMessage());
        }
    }
}
