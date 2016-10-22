<?php

namespace KevinOrriss\UserRoles\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        // ensure the user can browse role groups
        Auth::user()->checkRole('role_group_browse');

        // get the role groups, including deleted
        $role_groups = RoleGroup::orderBy('name', 'asc')->withTrashed()->get();

        // display browse page
        return view('userroles::role_group_browse')
            ->with('role_groups', $role_groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ensure the user can create role groups
        Auth::user()->checkRole('role_group_create');

        // get the current roles and role groups that can be assigned
        $roles = Role::orderBy('name', 'asc')->get();
        $role_groups = RoleGroup::orderBy('name', 'asc')->get();

        // display the create page
        return view('userroles::role_group_create')
            ->with('roles', $roles)
            ->with('role_groups', $role_groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ensure the user can create role groups
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

        try
        {
            if (Auth::user()->hasRole('role_assign_group'))
            {
                $role_group->roles()->sync($request->input('roles') ?? array());
            }
            if (Auth::user()->hasRole('role_group_assign_group'))
            {
                $role_group->children()->sync($request->input('sub_groups') ?? array());
            }
        }
        catch (QueryException $e)
        {
            Session::flash('error', 'Infinite loops in role groups are not allowed');
            return redirect(route('role_groups.create', $role_group->id))->withInput();
        }

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
        // ensure the user can browse role groups
        Auth::user()->checkRole('role_group_browse');

        // get the role group
        $role_group = RoleGroup::withTrashed()->findOrFail($id);

        // if the role group is deleted and the user cannot restore it then fail
        if ($role_group->trashed() && !Auth::user()->hasRole('role_group_restore'))
        {
            throw (new ModelNotFoundException)->setModel(get_class($role_group));
        }

        // get the roles and sub role groups for this role group
        $roles = $role_group->roles()->orderBy('name', 'asc')->get();
        $sub_groups = $role_group->children()->orderBy('name', 'asc')->get();

        // display the view
        return view('userroles::role_group_show')
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
        // ensure the user can edit role groups
        Auth::user()->checkRole('role_group_edit');

        // get the role group being edited, and every role/role group
        $role_group = RoleGroup::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();
        $role_groups = RoleGroup::orderBy('name', 'asc')->get();

        // get the roles and sub role groups for this role group
        $role_group_roles = $role_group->roles()->get();
        $role_group_groups = $role_group->children()->get();

        // display the edit page
        return view('userroles::role_group_edit')
            ->with('role_group', $role_group)
            ->with('roles', $roles)
            ->with('role_groups', $role_groups)
            ->with('role_group_roles', $role_group_roles)
            ->with('role_group_groups', $role_group_groups);
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
        // ensure the user can edit role groups
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
            if (Auth::user()->hasRole('role_assign_group'))
            {
                $role_group->roles()->sync($request->input('roles') ?? array());
            }
            if (Auth::user()->hasRole('role_group_assign_group'))
            {
                $role_group->children()->sync($request->input('sub_groups') ?? array());
            }
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
        // ensure the user can delete role groups
        Auth::user()->checkRole('role_group_delete');

        // delete the role group and return to index
        RoleGroup::findOrFail($id)->delete();
        Session::flash('success', 'Role Group successfully deleted');
        return redirect(route('role_groups.index'));
    }
}
