<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KyogiPlan;
use App\Http\Requests\Admin\KyogiPlanListRequest;
use App\Http\Requests\Admin\KyogiPlanRequest;
use App\Services\Admin\KyogiPlanService;

class KyogiPlanController extends Controller
{
    private $service;
    public function __construct(KyogiPlanService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  KyogiPlanListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(KyogiPlanListRequest $request)
    {
        return $this->service->getList($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KyogiPlanRequest $request
     * @return void
     */
    public function store(KyogiPlanRequest $request)
    {
        $this->service->create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return KyogiPlan
     */
    public function show($id)
    {
        return $this->service->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return void
     */
    public function destroy($id)
    {
        $this->service->delete($id);
    }
    
    /**
     * 入力条件取得
     *
     * @param  Request $request
     * @return array
     */
    public function getConds(Request $request) : array
    {
        return $this->service->getCondSession($request);
    }
    
    /**
     * 入力条件セット
     *
     * @param  KyogiPlanListRequest $request
     * @return void
     */
    public function setConds(KyogiPlanListRequest $request) : void
    {
        $this->service->setCondSession($request);
    }
}