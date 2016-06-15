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
        Auth::user()->checkRole('role_browse');

        // get the roles and calculate column row numbers
        $roles = Role::orderBy('name', 'asc')->get();
        $count = count($roles);
        $per_col = (float)$count/3.0;
        $col1_start = 0;
        $col2_start = ceil($per_col);
        $col3_start = $col2_start + ceil($per_col);

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
        Auth::user()->checkRole('role_create');
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
        Auth::user()->checkRole('role_create');

        // validate the request
        $validator = Validator::make($request->all(), Role::rules(), Role::messages());
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
        Auth::user()->checkRole('role_browse');

        // get the role and display
        $role = Role::findOrFail($id);
        return view('userroles.roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->checkRole('role_edit');

        // get the role and display
        $role = Role::findOrFail($id);
        return view('userroles.roles.edit')->with('role', $role);
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
        Auth::user()->checkRole('role_edit');

        $role = Role::findOrFail($id);
        
        $validator = Validator::make($request->all(), Role::rules($role->id), Role::messages());
        if ($validator->fails())
        {
            return redirect(route('roles.edit'), $role->id)->withErrors($validator)->withInput();
        }

        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();

        Session::flash('success', 'Changes saved successfully');
        return redirect(route('roles.show', $role->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->checkRole('role_delete');

        Role::findOrFail($id)->delete();

        Session::flash('success', 'Role successfully deleted');
        return redirect(route('roles.index'));
    }
}
