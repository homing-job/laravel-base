<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\KyogiListRequest;
use App\Http\Requests\Admin\Master\KyogiRequest;
use App\Services\Admin\Master\KyogiService;

class KyogiController extends Controller
{
    private $service;
    public function __construct(KyogiService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  KyogiListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(KyogiListRequest $request)
    {
        return $this->service->getList($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KyogiRequest $request
     * @return void
     */
    public function store(KyogiRequest $request)
    {
        $this->service->create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return void
     */
    public function show($id) : void
    {
        $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  KyogiRequest $request
     * @param  string $id
     * @return void
     */
    public function update(KyogiRequest $request, $id)
    {
        $this->service->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id
     * @return void
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
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
     * @param  KyogiListRequest $request
     * @return void
     */
    public function setConds(KyogiListRequest $request) : void
    {
        $this->service->setCondSession($request);
    }
    

    /**
     * excel出力
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel() {
        return $this->service->exportExcel();
    }
}