<?php

namespace KevinOrriss\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
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
     * Returns the RoleGroup objects that this Role belongs to.
     * This is not recursive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roleGroups()
    {
        return $this->belongsToMany('KevinOrriss\UserRoles\Models\RoleGroup', 'role_group_roles', 'role_id', 'role_group_id')
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
        return $this->belongsToMany(config('userroles.user_model'), 'user_roles', 'role_id', 'user_id')
            ->whereNull('user_roles.deleted_at');
    }
}
