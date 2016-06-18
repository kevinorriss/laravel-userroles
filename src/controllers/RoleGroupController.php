<?php

namespace KevinOrriss\UserRoles\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Auth;
use Session;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use KevinOrriss\UserRoles\Models\Role;
use KevinOrriss\UserRoles\Models\RoleGroup;

class RoleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->checkRole('role_group_browse');

        // get the roles and calculate column row numbers
        $role_groups = RoleGroup::orderBy('name', 'asc')->get();
        $count = count($role_groups);
        $per_col = (float)$count/3.0;
        $col1_start = 0;
        $col2_start = ceil($per_col);
        $col3_start = $col2_start + ceil($per_col);

        // display browse page
        return view('userroles.role_groups.browse')
            ->with('role_groups', $role_groups)
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
        Auth::user()->checkRole('role_group_create');

        // display the create page
        return view('userroles.role_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->checkRole('role_group_create');

        // validate the request
        $validator = Validator::make($request->all(), RoleGroup::rules(), RoleGroup::messages());
        if ($validator->fails())
        {
            return redirect(route('role_groups.create'))->withErrors($validator)->withInput();
        }

        // create and save the role group
        $role_group = new RoleGroup;
        $role_group->name = $request->input('name');
        $role_group->description = $request->input('description');
        $role_group->save();

        // flash a success message and redirect to the roles.index route
        Session::flash('success', "Role Group " . $role_group->name . " created successfully");
        return redirect(route('role_groups.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Auth::user()->checkRole('role_group_browse');

        // get the role group and display
        $role_group = RoleGroup::findOrFail($id);
        $roles = $role_group->roles()->orderBy('name', 'asc')->get();
        $sub_groups = $role_group->children()->orderBy('name', 'asc')->get();
        return view('userroles.role_groups.show')
            ->with('role_group', $role_group)
            ->with('roles', $roles)
            ->with('sub_groups', $sub_groups);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->checkRole('role_group_edit');

        // get the role group being edited, and every role/role group
        $role_group = RoleGroup::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();
        $sub_groups = RoleGroup::orderBy('name', 'asc')->get();

        // get the IDs of the role groups assigned roles
        $selected_role_objects = $role_group->roles()->get();
        $selected_roles = array();
        foreach($selected_role_objects as $selected_role_object)
        {
            $selected_roles[] = $selected_role_object->id;
        }

        // get the IDs of the role groups sub role groups
        $selected_sub_group_objects = $role_group->children()->get();
        $selected_sub_groups = array();
        foreach($selected_sub_group_objects as $selected_sub_group_object)
        {
            $selected_sub_groups[] = $selected_sub_group_object->id;
        }

        // display the edit page
        return view('userroles.role_groups.edit')
            ->with('role_group', $role_group)
            ->with('roles', $roles)
            ->with('selected_roles', $selected_roles)
            ->with('sub_groups', $sub_groups)
            ->with('selected_sub_groups', $selected_sub_groups);
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
        Auth::user()->checkRole('role_group_edit');

        // get role group and validate
        $role_group = RoleGroup::findOrFail($id);
        $validator = Validator::make($request->all(), RoleGroup::rules($role_group->id), RoleGroup::messages());
        if ($validator->fails())
        {
            return redirect(route('role_groups.edit'), $role_group->id)->withErrors($validator)->withInput();
        }

        // if trying to assign a role group to itself
        if (in_array($id, $request->input('sub_groups') ?? array()))
        {
            Session::flash('error', 'A role group cannot be a child to itself');
            return redirect(route('role_groups.edit', $role_group->id))->withInput();
        }

        // save the role group
        $role_group->name = $request->input('name');
        $role_group->description = $request->input('description');
        $role_group->save();
        try
        {
            $role_group->roles()->sync($request->input('roles') ?? array());
            $role_group->children()->sync($request->input('sub_groups') ?? array());
        }
        catch (QueryException $e)
        {
            Session::flash('error', 'Infinite loops in role groups are not allowed');
            return redirect(route('role_groups.edit', $role_group->id))->withInput();
        }

        // flash message and display the role group
        Session::flash('success', 'Changes saved successfully');
        return redirect(route('role_groups.show', $role_group->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->checkRole('role_group_delete');

        // delete the role group and return to index
        RoleGroup::findOrFail($id)->delete();
        Session::flash('success', 'Role Group successfully deleted');
        return redirect(route('role_groups.index'));
    }
}
