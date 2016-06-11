<?php

namespace KevinOrriss\UserRoles;

use InvalidArgumentException;
use KevinOrriss\UserRoles\Models\Role;
use KevinOrriss\UserRoles\Models\RoleGroup;

trait RoleUser
{
	/**
     * Returns the Role objects that belong to this User.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function roles()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\Models\Role', 'user_roles', 'user_id', 'role_id')
            ->whereNull('user_roles.deleted_at');
    }

    /**
     * Returns the RoleGroup objects that belong to this User.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function roleGroups()
    {
    	return $this->belongsToMany('KevinOrriss\UserRoles\Models\RoleGroup', 'user_role_groups', 'user_id', 'role_group_id')
            ->whereNull('user_role_groups.deleted_at');
    }

    /**
     * Returns if the RoleUser contains the given Role. This 
     * function is recursive and searches for the Role within
     * the sub RoleUser RoleGroups.
     *
     * @param string|KevinOrriss\UserRoles\Models\Role $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        // handle the parameter type
        if (is_string($role))
        {
            $search_role = Role::where('name', $role)->firstOrFail();
        }
        else if (is_a($role, "KevinOrriss\UserRoles\Models\Role"))
        {
            $search_role = $role;
        }
        else
        {
            throw new InvalidArgumentException('role must be a Role instance or string of the role name');
        }

        // check if this Role Group has the given role
        $can = count($this->roles()->where('roles.id', $search_role->id)->first()) > 0;
        if ($can) { return TRUE; }

        // search each RoleGroup for the given Role
        $groups = $this->roleGroups()->get();
        foreach($groups as $group)
        {
            if ($group->hasRole($search_role)) { return TRUE; }
        }

        // role not found
        return FALSE;
    }
}