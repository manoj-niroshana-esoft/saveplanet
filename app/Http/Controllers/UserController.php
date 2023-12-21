<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function usermanagement()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "User Management"]
        ];
        return view('/pages/view-user-management', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function view_users()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['name' => "User Management Detail"]
        ];
        $users = User::orderBy('u_id', 'desc')->get();
        $users->transform(function ($user) {
            if($user->user_type == 1){
                $user_type = "Complainer";
            }else if($user->user_type == 2){
                $user_type = "Field Officer";
            }else {
                $user_type = "Administrator";
            }
            return [
                'u_id' => $user->u_id,
                'first_Name' => $user->first_name,
                'last_Name' => $user->last_name,
                'address' => $user->address,
                'nic' => $user->nic,
                'email' => $user->email,
                'user_type' => $user_type
            ];
        });
        return view('/pages/view-user-management-details', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users
        ]);
    }

    public function add_user_management()
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['link' => "view_users", 'name' => "View User"], ['name' => "Add User"]
        ];
        return view('/pages/add-user-management-details', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function register_user_management(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $request->validate([
                'email_column' => 'required|email|unique:users',
                'password_column' => 'required|min:8',
            ]);
            User::create([
                'first_name' => $request->fname_column,
                'last_name' => $request->lname_column,
                'email' => $request->email_column,
                'nic' =>  $request->nic_column,
                'address' =>  $request->address_column,
                'user_type' =>  $request->user_type_column,
                'password' =>  $request->password_column,
                'created_at' =>  now()
            ]);

            DB::commit();
            return redirect('view-user-management')->with('success', 'User Created in successfully!');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function edit_user_management(Request $request)
    {
        $breadcrumbs = [
            ['link' => "dashboard-analytics", 'name' => "Home"], ['link' => "view_users", 'name' => "View User"], ['name' => "Edit User"]
        ];

        $u_id = $request->id;
        $users = User::where('u_id', $u_id)->get();
        $users->transform(function ($user) {
            if($user->user_type == 1){
                $user_type = "Complainer";
            }else if($user->user_type == 2){
                $user_type = "Field Officer";
            }else {
                $user_type = "Administrator";
            }

            return [
                'user_id' => $user->u_id,
                'first_Name' => $user->first_name,
                'last_Name' => $user->last_name,
                'address' => $user->address,
                'nic' => $user->nic,
                'user_type' => $user_type,
                'email' => $user->email
            ];
        });

        return view('/pages/edit-user-management-details', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users
        ]);
    }

    public function update_user_management(Request $request, User $user)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|min:6',
        ]);
    
        $user->update([
            'first_name' => $request->input('fname_column'),
            'last_name' => $request->input('lname_column'),
            'email' => $request->input('email_column'),
            'nic' =>  $request->input('nic_column'),
            'address' =>  $request->input('address_column'),
            'user_type' =>  $request->input('user_type_column'),
            'password' =>  $request->input('password_column'),
            'updated_at' =>  now(),
        ]);
    
        return redirect()->route('view-user-management')->with('success', 'User updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return redirect()->route('view-user-management')->with('success', 'User deleted successfully!');
    }
}