<?php

namespace Modules\ModuleControl\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->hasMany(UserGroupPermission::class, 'user_group_id');
    }

    public function scopeSearch($query, $term)
    {
        $query->where('name', 'like', sprintf('%%s%', $term));
    }
}
