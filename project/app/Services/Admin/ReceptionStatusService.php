<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\ReceptionStatusListRequest;
use App\Repositories\Admin\ReceptionStatusRepository;

/**
 * サービスクラス
 *
 */
class ReceptionStatusService {
    private $repository;
    public function __construct(ReceptionStatusRepository $repository){
        $this->repository = $repository;
    }
    
    // 一覧取得
    public function getList(ReceptionStatusListRequest $request): array{
        return  $this->repository->getList($request)->ToArray();
    }
    
    // 削除
    public function delete($id): void{
        $this->repository->delete($id);
    }
    
    // 条件セッション取得
    public function getCondSession(Request $request): array{
        return ReceptionStatusListRequest::getRequestSession($request);
    }
    
    // 条件セッションセット
    public function setCondSession(Request $request): void{
        ReceptionStatusListRequest::setRequestSession($request);
    }
}
