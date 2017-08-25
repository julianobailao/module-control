<?php

namespace Modules\ModuleControl\Entities\Core;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'name', 'alias', 'description', 'active'
    ];

    public static function createModule($moduleName)
    {
        $moduleFile = base_path(sprintf('/Modules/%s/module.json', $moduleName));
        $moduleData = json_decode(file_get_contents($moduleFile), true);
        $module = ModuleModel::where('alias', $moduleData['alias'])->first();

        if (! $module) {
            $module = new ModuleModel();
        }

        $module->fill($moduleData)->save();

        return $module;
    }

    public function routes()
    {
        return $this->hasMany(RouteModel::class, 'module_id');
    }
}
