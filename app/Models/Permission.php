<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];
    /*
    *****************************************************************************
    *************************** Begin RELATIONS Area ****************************
    *****************************************************************************
    */
    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user');
    } // To Return The Relation Between Role and Users

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    } // To Return The Relation Between Role and Permissions

    /*
    *****************************************************************************
    *************************** Begin SCOPE Area ********************************
    *****************************************************************************
    */
    public function scopeSearch($query, $request)
    {
        return $query->where($request['column'], 'like', "%" . $request['text'] . "%");
    } // To do Some Query


    /*
    *****************************************************************************
    *************************** Begin ATTRIBUTE Area ****************************
    *****************************************************************************
    */
    public function setNameAttribute($name)
    {
        return $this->attributes['name'] = str_replace(' ', '_', strtolower($name));
    } // Auto Do Some Style on The Name

    public function getDisplayNameAttribute($name)
    {
        return $this->attributes['display_name'] = strtolower( ucwords($name) );
    } // Auto Do Some Style on The Display Name
}
