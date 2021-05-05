<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReceptionStatusListRequest;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\ReceptionStatusService;

class ReceptionStatusController extends Controller
{
    private $service;
    public function __construct(ReceptionStatusService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  ReceptionStatusListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ReceptionStatusListRequest $request)
    {
        return $this->service->getList($request);
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
     * @param  ReceptionStatusListRequest $request
     * @return void
     */
    public function setConds(ReceptionStatusListRequest $request) : void
    {
        $this->service->setCondSession($request);
    }
}