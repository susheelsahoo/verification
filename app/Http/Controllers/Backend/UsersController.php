<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CaseStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_id  = Auth::guard('admin')->user()->id;
        $users = User::where('admin_id', $session_id)->get();
        return view('backend.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  = Role::all();
        return view('backend.pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name'      => 'required|max:50',
            'username'  => 'required|max:100|unique:users',
            'email'     => 'required|max:100',
            'password'  => 'required|min:6|confirmed',
        ]);
        // Create New User
        $user = new User();
        $user->username         = $request->username;
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->admin_id     = Auth::guard('admin')->user()->id;
        $user->password     = Hash::make($request->password);
        $user->save();

        // if ($request->roles) {
        //     $user->assignRole($request->roles);
        // }

        session()->flash('success', 'User has been created !!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles  = Role::all();
        return view('backend.pages.users.edit', compact('user', 'roles'));
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
        // Create New User
        $user = User::find($id);

        // Validation Data
        $request->validate([
            'name'      => 'required|max:50',
            'username'  => 'required|max:100|unique:users,username,' . $id,
            'email'     => 'required|max:100',
            'password'  => 'required|min:6|confirmed',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        session()->flash('success', 'User has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }

        session()->flash('success', 'User has been deleted !!');
        return back();
    }
    public function getAgent($bankId = null)
    {
        $login_user_id  = Auth::guard('admin')->user()->id;
        $users = User::where('admin_id', $login_user_id)->get()->toArray();

        if ($bankId !== null) {
            return response()->json(['users' => $users]);
        } else {
            return response()->json(['error' => 'something went wrong please contect to admin.'], 400);
        }
    }

    public function getCaseStatus($type, $parent_id = null)
    {
        if (is_null($parent_id)) {
            $caseSubStatus = CaseStatus::where('type', $type)->orderBy('name', "ASC")->get();
        } else {
            $caseSubStatus = CaseStatus::where('parent_id', $parent_id)->where('type', $type)->orderBy('name', "ASC")->get();
        }


        if ($caseSubStatus !== null) {
            return response()->json(['caseSubStatus' => $caseSubStatus]);
        } else {
            return response()->json(['error' => 'Bank ID not provided.'], 400);
        }
    }
}
