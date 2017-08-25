<?php

namespace Modules\ModuleControl\Http\Middleware;

use Auth;
use Route;
use Closure;
use Illuminate\Http\Request;
use Modules\ModuleControl\Entities\Core\RouteModel;
use Modules\ModuleControl\Entities\Core\ModuleModel;
use Modules\ModuleControl\Entities\Core\ActionModel;

class PermissionControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = Route::getCurrentRoute();
        $action = $route->getAction();
        list($controler, $method) = explode("@", $action['controller']);
        $class = new \ReflectionClass($controler);
        $moduleName = explode('\\', $class->getNamespaceName())[1];
        $moduleModel = ModuleModel::createModule($moduleName);
        $routeModel = RouteModel::createRoute($moduleModel, $route);
        $actionModel = ActionModel::createController($routeModel, $class->getNamespaceName(), $class->getShortName(), $method);

        if (! $this->checkPermission(Auth::user(), $actionModel)) {
            return response([
                'error' => true,
                'permission' => false,
            ],401);
        }

        return $next($request);
    }

    protected function checkPermission($user, $action)
    {
        if (! $user) {
            return false;
        }

        $permission = $user->userGroup->permissions()
            ->where('module_id', $action->route->module->id)
            ->where(function ($q) use ($action) {
                $q->where('module_route_id', $action->route->id);
                $q->orWhere('module_route_id', null);
            })
            ->where(function ($q) use ($action) {
                $q->where('module_route_action_id', $action->id);
                $q->orWhere('module_route_action_id', null);
            })
            ->where('grant_access', true);

        if ($permission->count() == 0) {
            return false;
        }

        return true;
    }
}
