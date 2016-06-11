<?php

namespace KevinOrriss\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleGroup extends Model
{
    /**
     * When deleting the model, it is not actually removed from the database, instead
     * the deleted_at column has the current time set
     */
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The format of dates for this model
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * Returns the Role objects that belong to this RoleGroup.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\Models\Role', 'role_group_roles', 'role_group_id', 'role_id')
            ->whereNull('role_group_roles.deleted_at');
    }

    /**
     * Returns the Model objects, specified in config('userroles.user_model'), that this Role belongs to.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('userroles.user_model'), 'user_role_groups', 'role_group_id', 'user_id')
            ->whereNull('user_role_groups.deleted_at');
    }

    /**
     * Returns the RoleGroup objects that this RoleGroup belongs to.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parents()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\Models\RoleGroup', 'role_group_groups', 'sub_role_group_id', 'role_group_id')
            ->whereNull('role_group_groups.deleted_at');
    }

    /**
     * Returns the RoleGroup objects that belong to this RoleGroup.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\Models\RoleGroup', 'role_group_groups', 'role_group_id', 'sub_role_group_id')
            ->whereNull('role_group_groups.deleted_at');
    }

    /**
     * Returns if the Role Group contains the given Role. This 
     * function is recursive and searches for the Role within
     * the sub Role Groups.
     *
     * @param KevinOrriss\UserRoles\Models\Role $role
     *
     * @return boolean
     */
    public function hasRole(Role $role)
    {
        // check if this Role Group has the given role
        $can = count($this->roles()->where('roles.id', $role->id)->first()) > 0;
        if ($can) { return TRUE; }

        // recursively call this function on all sub Role Groups
        $children = $this->children()->get();
        foreach($children as $child)
        {
            if ($child->hasRole($role)) { return TRUE; }
        }

        // role not found
        return FALSE;
    }
}
