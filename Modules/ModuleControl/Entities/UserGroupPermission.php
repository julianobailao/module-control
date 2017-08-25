<?php

namespace Modules\ModuleControl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\ModuleControl\Entities\Core\ActionModel;

class UserGroupPermission extends Model
{
    protected $fillable = [
        'grant_access', 'module_id', 'route_id', 'action_id'
    ];

    public static function generateForAll($defaultValue = false)
    {
        UserGroup::all()->get()->each(function ($userGroup) use ($defaultValue) {
            UserGroupPermission::generateForOne($userGroup, $defaultValue);
        });
    }

    public static function generateForOne(UserGroup $userGroup, $defaultValue = false)
    {
        ActionModel::all()->get()->each(function ($action) use ($userGroup, $defaultValue) {
            $userGroup
                ->permissions()
                ->where('module_id', $action->route->module->id)
                ->where('module_route_id', $action->route->id)
                ->where('module_route_action_id', $action->id)
                ->first();

            if (! $userGroup) {
                $userGroup = new UserGroupPermission();
            }

            $userGroup
                ->permissions()
                ->save($userGroup->fill([
                    'module_id' => $action->route->module->id,
                    'module_route_id' => $action->route->id,
                    'module_route_action_id' => $action->id,
                    'grant_access' => $defaultValue,
                ]));
        });
    }
}
