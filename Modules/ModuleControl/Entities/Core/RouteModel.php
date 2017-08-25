<?php

namespace Modules\ModuleControl\Entities\Core;


use Illuminate\Routing\Route;
use Illuminate\Database\Eloquent\Model;

class RouteModel extends Model
{
    protected $table = 'module_routes';

    protected $fillable = [
        'uri', 'method'
    ];

    public static function createRoute(ModuleModel $module, Route $route)
    {
        $routeData = [
            'uri' => $route->uri,
            'method' => $route->methods[0],
        ];

        $routeModel = $module
            ->routes()
            ->where('uri', $routeData['uri'])
            ->where('method', $routeData['method'])
            ->first();

        if (! $routeModel) {
            $routeModel = new RouteModel();
        }

        return $module->routes()->save($routeModel->fill($routeData));
    }

    public function controllers()
    {
        return $this->hasMany(ActionModel::class, 'module_route_id');
    }

    public function module()
    {
        return $this->belongsTo(ModuleModel::class, 'module_id');
    }
}
