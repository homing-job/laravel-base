<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Services\Content\ConfirmationService;
use App\Http\Controllers\Controller;

class ConfirmationController extends Controller
{
    private $service;
    public function __construct(ConfirmationService $service){
        $this->service = $service;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 入力データ取得
        $input_data = $this->service->getInputReception();
        return view('content.confirmation')->with(['input_data' => $input_data
                                                , 'kyogi' => $this->service->getKyogi($input_data['reception']['kyogi_id'])
                                                , 'is_admin' => false]);
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminIndex($reception_id)
    {
        $reseption = $this->service->getReception($reception_id);
        return view('content.confirmation')->with(['input_data' => $reseption
                                                , 'kyogi' =>  $this->service->getKyogi($reseption['reception']['kyogi_id'])
                                                , 'is_admin' => true]);
    }

    /**
     * 登録
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $this->service->create();
        return route('complete');
    }
}
