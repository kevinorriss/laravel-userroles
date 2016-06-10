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
     * @return Role[]
     */
    public function roles()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\App\Role', 'role_group_roles', 'role_group_id', 'role_id')->withTimestamps();
    }

    /**
     * Returns the RoleGroup objects that this RoleGroup belongs to.
     * This is not recursive
     *
     * @return RoleGroup[]
     */
    public function parents()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\App\RoleGroup', 'role_group_groups', 'sub_role_group_id', 'role_group_id')->withTimestamps();
    }

    /**
     * Returns the RoleGroup objects that belong to this RoleGroup.
     * This is not recursive
     *
     * @return RoleGroup[]
     */
    public function children()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\App\RoleGroup', 'role_group_groups', 'role_group_id', 'sub_role_group_id')->withTimestamps();
    }
}
