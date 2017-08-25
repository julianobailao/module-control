<?php

namespace Modules\ModuleControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ModuleControl\Entities\UserGroup;
use Modules\ModuleControl\Http\Requests\UserGroupRequest;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return UserGroup::search($request->get('search'))
            ->orderBy('name')
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserGroup $userGroup
     *
     * @return Response
     */
    public function show(UserGroup $userGroup)
    {
        return $userGroup;
    }

    /**
     * Show the specified resource.
     *
     * @param  UserGroupRequest $request
     *
     * @return Response
     */
    public function store(UserGroupRequest $request)
    {
        return response($this->save($request, new UserGroup()), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserGroupRequest $request
     * @param  UserGroup $userGroup
     *
     * @return Response
     */
    public function update(UserGroupRequest $request, UserGroup $userGroup)
    {
        return $this->save($request, $userGroup);
    }

    protected function save(UserGroupRequest $request, UserGroup $userGroup)
    {
        $userGroup
            ->fill($request->all())
            ->save();

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
