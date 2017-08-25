<?php

namespace Modules\ModuleControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ModuleControl\Entities\User;
use Modules\ModuleControl\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return User::search($request->get('search'))
            ->orderBy('name')
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the specified resource.
     *
     * @param  UserRequest $request
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        return response($this->save($request, new User()), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  User $user
     *
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        return $this->save($request, $user);
    }

    protected function save(UserRequest $request, User $user)
    {
        $payload = $request->all();

        if (isset($payload['password'])) {
            $payload['password'] = bcrypt($payload['password']);
        }

        $user
            ->fill($payload)
            ->save();

        return $this->show($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param  User $user
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        if (! $user->delete()) {
            return response(['unable_to_delete'], 500);
        }

        return response(null, 204);
    }
}
