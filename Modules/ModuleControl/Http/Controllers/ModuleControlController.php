<?php

namespace Modules\ModuleControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ModuleControl\Entities\RouteModel;
use Modules\ModuleControl\Entities\ModuleModel;
use Modules\ModuleControl\Entities\ActionModel;

class ModuleControlController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(\Route $route)
    {
        return view('modulecontrol::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('modulecontrol::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('modulecontrol::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('modulecontrol::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
