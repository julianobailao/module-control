<?php

Route::group([
    'prefix' => 'api',
    'middleware' => ['api'],
    'namespace' => 'Modules\ModuleControl\Http\Controllers'
], function() {
    Route::post('/auth', 'AuthController@login');

    Route::middleware(['jwt.auth', 'permissions'])->group(function () {
        Route::resource('/users', 'UserController', ['except' => ['create', 'edit']]);
        Route::resource('/user-groups', 'UserGroupController', ['except' => ['create', 'edit']]);
        Route::resource('/user-groups.permissions', 'UserGroupPermissionController', ['except' => ['create', 'edit']]);
    });
});
