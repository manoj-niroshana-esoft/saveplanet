<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuditlogController extends Controller
{
    public function view_audit_log()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "View Audit Log"]
        ];
        $audit_logs = AuditLog::all();
        $audit_logs->transform(function ($audit_log) {
            $user = User::where('u_id', $audit_log->u_id)->first(['first_name', 'last_name']);
            return [
                'u_id' => $user->first_name . ' ' . $user->last_name,
                'section_name' => $audit_log->section_name,
                'action' => $audit_log->action,
                'previous_records' => $audit_log->previous_records != null ? $audit_log->previous_records : '-',
                'new_records' => $audit_log->new_records,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $audit_log->created_at)->format('Y-m-d H:i:s'),
            ];
        });
        return view('/pages/view-audit-log', [
            'breadcrumbs' => $breadcrumbs,
            'audit_logs' => $audit_logs,
        ]);
    }
}
