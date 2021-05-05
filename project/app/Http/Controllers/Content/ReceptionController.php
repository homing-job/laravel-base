<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\Content\ReceptionRequest;
use Illuminate\Http\Request;
use App\Services\Content\ReceptionService;
use App\Http\Controllers\Controller;

class ReceptionController extends Controller
{
    private $service;
    public function __construct(ReceptionService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('content.reception');
    }

    /**
     * バリデーション
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function validation(ReceptionRequest $request)
    {
        $this->service->setInputData($request);
        return route('confirmation');
    }

    /**
     * 競技情報取得
     *
     * @return array
     */
    public function getKyogis() : array
    {
        return $this->service->getKyogis();
    }

    /**
     * 競技名取得
     *
     * @return array
     */
    public function getKyogiNms()
    {
        return $this->service->getKyogiNms();
    }

    /**
     * 登録データ(初期化)
     *
     * @return array
     */
    public function getInputData(Request $request)
    {
        return $this->service->getInputData($request->isReset);
    }
}
