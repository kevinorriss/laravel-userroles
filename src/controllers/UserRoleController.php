<?php

namespace KevinOrriss\UserRoles\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        return "TODO";
    }
}
