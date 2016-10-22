<?php

namespace KevinOrriss\UserRoles\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App;
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
        // ensure the user can browse roles
        Auth::user()->checkRole('role_browse');

        // get all the roles, including deleted
        $roles = Role::orderBy('name', 'asc')->withTrashed()->get();

        // display the browse page
        return view('userroles::role_browse')
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ensure the user can create roles
        Auth::user()->checkRole('role_create');

        // display the create page
        return view('userroles::role_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ensure the user can create roles
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
        // ensure the user can browse roles
        Auth::user()->checkRole('role_browse');

        // get the role
        $role = Role::withTrashed()->findOrFail($id);

        // if the role is deleted and the user cannot restore then fail
        if ($role->trashed() && !Auth::user()->hasRole('role_restore'))
        {
            throw (new ModelNotFoundException)->setModel(get_class($role));
        }

        // display the role
        return view('userroles::role_show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ensure the user can edit roles
        Auth::user()->checkRole('role_edit');

        // get the role
        $role = Role::findOrFail($id);

        // display the role to edit
        return view('userroles::role_edit')->with('role', $role);
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
        // get the role
        $role = Role::withTrashed()->findOrFail($id);

        // if the role has been deleted, then restore it
        if ($role->trashed())
        {
            // ensure the user can restore roles
            Auth::user()->checkRole('role_restore');

            // restore the role
            $role->restore();

            // flash a success message and show the role
            Session::flash('success', 'Role successfully restored');
            return redirect(route('roles.show', $role->id));
        }

        // ensure the user can edit roles
        Auth::user()->checkRole('role_edit');

        $validator = Validator::make($request->all(), Role::rules($role->id), Role::messages());
        if ($validator->fails())
        {
            return redirect(route('roles.edit', $role->id))->withErrors($validator)->withInput();
        }

        // save the changes
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();

        // flash a success message and show the role
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
        // get the role
        $role = Role::withTrashed()->findOrFail($id);

        // if destroying a soft-deleted role
        if ($role->trashed())
        {
            // ensure the user can destroy roles
            Auth::user()->checkRole('role_destroy');

            // detatch all relations and delete the role
            $role->roleGroups()->sync([]);
            $role->users()->sync([]);
            $role->forceDelete();

            // display a success message on the role index page
            Session::flash('success', 'Role successfully destroyed');
            return redirect(route('roles.index'));
        }

        // ensure the user can delete roles
        Auth::user()->checkRole('role_delete');

        // delete the role and show the index page
        Role::findOrFail($id)->delete();
        Session::flash('success', 'Role successfully deleted');
        return redirect(route('roles.index'));
    }
}
