<?php

namespace KevinOrriss\UserRoles\Models;

use InvalidArguementException;
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
            ->withTimestamps();
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
            ->withTimestamps();
    }

    /**
     * Returns an array of validation rules used for the Role model. If an id
     * of a Role is passed, then any unique constraint will be ignored for the
     * given id. Used for updates.
     *
     * @param int|NULL $id
     *
     * @throws InvalidArguementException
     *
     * @return string[]
     */
    public static function rules($id=NULL)
    {
        if (!is_null($id) && !is_int($id))
        {
            throw new InvalidArguementException('Param [$id] is expected to be NULL or an Integer');
        }

        return [
            'name' => 'bail|required|min:3|max:20|regex:#^[a-z]+(_[a-z]+)*$#|unique:roles,name' . (!is_null($id) ? ",".$id : ""),
            'description' => 'bail|required|min:10'];
    }

    /**
     * Returns an array of validation messages to use on failure.
     * These are custom messages. This array is not a class constant
     * purely for uniform code when used with the rules() function.
     *
     * @return string[]
     */
    public static function messages()
    {
        return [
            'name.regex' => 'Name can contain only lower case a-z seperated by single underscores'];
    }
}
