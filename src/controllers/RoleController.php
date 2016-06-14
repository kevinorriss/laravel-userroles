<?php

namespace KevinOrriss\UserRoles\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use KevinOrriss\UserRoles\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check user has role
        if (!Auth::user()->hasRole('role_browse'))
        {
            return redirect(url('/'));
        }

        // get the roles and calculate column row numbers
        $roles = Role::orderBy('name', 'asc')->get();
        $count = count($roles);
        $per_col = (float)$count/3.0;
        $col1_start = 0;
        $col2_start = ceil($per_col);
        $col3_start = $col2_start + floor($per_col);

        // pass the variables to the view
        return view('userroles.roles.browse')
            ->with('roles', $roles)
            ->with('count', $count)
            ->with('col1_start', $col1_start)
            ->with('col2_start', $col2_start)
            ->with('col3_start', $col3_start);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // check user has role
        if (!Auth::user()->hasRole('role_create'))
        {
            return redirect(url('/'));
        }

        return view('userroles.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check user has role
        if (!Auth::user()->hasRole('role_create'))
        {
            return redirect(url('/'));
        }

        // validate the request
        $validator = Validator::make($request->all(), Role::RULES, Role::MESSAGES);
        if ($validator->fails())
        {
            return redirect(route('roles.create'))->withErrors($validator)->withInput();
        }

        // create and save the role
        $role = new Role;
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();

        // flash a success message and redirect to the roles.index route
        Session::flash('success', "Role " . $role->name . " created successfully");
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "TODO: show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return "TODO: edit";
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
        return "TODO: update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "TODO: destroy";
    }
}
