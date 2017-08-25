<?php

namespace Modules\ModuleControl\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_group_id', 'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }

    public function scopeSearch($query, $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'like', sprintf('%%s%', $term))
                ->where('email', $term);
        });
    }
}
