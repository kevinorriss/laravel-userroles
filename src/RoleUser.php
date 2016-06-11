<?php

namespace KevinOrriss\UserRoles;

use InvalidArgumentException;
use KevinOrriss\UserRoles\Models\Role;
use KevinOrriss\UserRoles\Models\RoleGroup;

trait RoleUser
{
    /**
     * All the roles that the user has assigned, the keys of the 
     * array are the role names.
     *
     * @var Role[]
     */
    protected $roles;

	/**
     * Returns the Role objects that have been directly assigned to this user
     * This is not recursive call, to get all roles a user has, use allRoles
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
     * Loads all the roles the user has, directly or from role groups, and stores
     * each Role instance in the roles property.
     *
     * @return void
     */
    protected function loadRoles()
    {
        // set roles to be an empty array
        $this->roles = array();

        // load the roles directly assigned to the user
        $local_roles = $this->roles()->get();
        foreach($local_roles as $local_role)
        {
            $this->roles[$local_role->name] = $local_role;
        }

        // load roles from the role groups assigned to the user
        $role_groups = $this->roleGroups()->get();
        foreach($role_groups as $role_group)
        {
            $this->roles +=  $role_group->allRoles();
        }
    }

    /**
     * Returns the roles property which contains all the roles 
     * the user has been assigned directly or indirectly via
     * role groups.
     *
     * @return Role[]
     */
    public function allRoles()
    {
        if (is_null($this->roles))
        {
            $this->loadRoles();
        }
        return $this->roles;
    }

    /**
     * Returns if the RoleUser contains the given Role. This 
     * function is recursive and searches for the Role within
     * the sub RoleUser RoleGroups.
     *
     * @param string | string[] | Role | Role[] $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        $names = array();

        // handle the parameter type
        if (is_string($role))
        {
            $names[] = $role;
        }
        else if (is_a($role, "KevinOrriss\UserRoles\Models\Role"))
        {
            $names[] = $role->name;
        }
        else if (is_array($role))
        {
            foreach($role as $value)
            {
                if (is_string($value))
                {
                    $names[] = $value;
                }
                else if (is_a($value, "KevinOrriss\UserRoles\Models\Role"))
                {
                    $names[] = $value->name;
                }
                else
                {
                    throw new InvalidArgumentException('Parameter [$role] array can contain only Role instances or strings of role names');
                }
            }
        }
        else
        {
            throw new InvalidArgumentException('Parameter [$role] must be a Role instance or string of the role name');
        }

        // remove duplicates
        $names = array_unique($names);

        // get roles if havent already
        if (is_null($this->roles))
        {
            $this->loadRoles();
        }

        // search for the role names
        foreach($names as $name)
        {
            if (array_key_exists($name, $this->roles)) { return TRUE; }
        }
        return FALSE;
    }
}