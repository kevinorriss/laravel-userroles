<?php

namespace KevinOrriss\UserRoles\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use KevinOrriss\UserRoles\Models\Role;
use KevinOrriss\UserRoles\Models\RoleGroup;

class UserRoleController extends Controller
{
    /**
     * Display all users with links to view their roles
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ensure the user can browse user roles
        Auth::user()->checkRole('user_role_browse');

        // get the user models ordered by their unique names
        $users = config('userroles.user_model')::orderBy(config('userroles.user_name_column'), 'asc')->paginate(60);
        $user_name_column = config('userroles.user_name_column');
        $user_id_column = config('userroles.user_id_column');
        $count = count($users);
        $per_col = (float)$count/3.0;
        $col1_start = 0;
        $col2_start = ceil($per_col);
        $col3_start = $col2_start + ceil($per_col);
        
        // return the user browse view
        return view('userroles::user_index')
            ->with('users', $users)
            ->with('user_name_column', $user_name_column)
            ->with('user_id_column', $user_id_column)
            ->with('count', $count)
            ->with('col1_start', $col1_start)
            ->with('col2_start', $col2_start)
            ->with('col3_start', $col3_start);
    }

    public function show($id)
    {
        // ensure the user can browse user roles
        Auth::user()->checkRole('user_role_browse');

        // get the user from the database
        $user = config('userroles.user_model')::find($id);
        $roles = $user->roles()->orderBy('name', 'asc')->get();
        $role_groups = $user->roleGroups()->orderBy('name', 'asc')->get();
        $user_name_column = config('userroles.user_name_column');
        $user_id_column = config('userroles.user_id_column');

        // display the users roles and role groups
        return view('userroles::user_show')
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('role_groups', $role_groups)
            ->with('user_name_column', $user_name_column)
            ->with('user_id_column', $user_id_column);
    }

    public function edit($id)
    {
        // ensure the user can assign a role or role group to a user
        Auth::user()->checkRole(['role_assign_user', 'role_group_assign_user'], 'any');

        // get the user from the database
        $user = config('userroles.user_model')::find($id);
        $user_roles = $user->roles()->orderBy('name', 'asc')->get();
        $user_role_groups = $user->roleGroups()->orderBy('name', 'asc')->get();
        $user_name_column = config('userroles.user_name_column');
        $user_id_column = config('userroles.user_id_column');
        $roles = Role::orderBy('name', 'asc')->get();
        $role_groups = RoleGroup::orderBy('name', 'asc')->get();

        // display the users roles and role groups
        return view('userroles::user_edit')
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('role_groups', $role_groups)
            ->with('user_name_column', $user_name_column)
            ->with('user_id_column', $user_id_column)
            ->with('roles', $roles)
            ->with('role_groups', $role_groups);
    }
}
