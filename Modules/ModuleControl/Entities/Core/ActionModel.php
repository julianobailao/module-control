<?php

namespace Modules\ModuleControl\Entities\Core;

use Illuminate\Routing\Route;
use Illuminate\Database\Eloquent\Model;

class ActionModel extends Model
{
    protected $table = 'module_route_actions';

    protected $fillable = [
        'namespace', 'class_name', 'method'
    ];

    public static function createController(RouteModel $routeModel, $namespace, $class_name, $method)
    {
        $controller = $routeModel
            ->controllers()
            ->where('namespace', $namespace)
            ->where('class_name', $class_name)
            ->where('method', $method)
            ->first();

        if (! $controller) {
            $controller = new ActionModel();
        }

        return $routeModel->controllers()->save($controller->fill([
            'namespace' => $namespace,
            'class_name' => $class_name,
            'method' => $method,
        ]));
    }

    public function route()
    {
        return $this->belongsTo(RouteModel::class, 'module_route_id');
    }
}
