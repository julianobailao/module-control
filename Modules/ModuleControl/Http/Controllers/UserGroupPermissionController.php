<?php

namespace Modules\ModuleControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ModuleControl\Entities\UserGroup;
use Modules\ModuleControl\Http\Requests\UserGroupRequest;

class UserGroupPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @param  UserGroup $userGroup
     *
     * @return Response
     */
    public function index(Request $request, UserGroup $userGroup)
    {
        return $userGroup->permissions()
            ->search($request->get('search'))
            ->orderBy('id')
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserGroupPermission $userGroupPermission
     *
     * @return Response
     */
    public function show(UserGroupPermission $userGroupPermission)
    {
        return $userGroupPermission;
    }

    /**
     * Show the specified resource.
     *
     * @param  UserGroupRequest $request
     *
     * @return Response
     */
    public function store(UserGroupRequest $request, UserGroup $userGroup)
    {
        // $userGroup
        //     ->permissions()
        //     ->where();

        return $this->show($userGroup);
    }

    /**
     * Remove the specified resource from storage.
     * @param  UserGroup $userGroup
     *
     * @return Response
     */
    public function destroy(UserGroup $userGroup)
    {
        if (! $userGroup->delete()) {
            return response(['unable_to_delete'], 500);
        }

        return response(null, 204);
    }
}
