<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Models\KyogiPlan;
use App\Http\Requests\Admin\KyogiPlanListRequest;
use App\Http\Requests\Admin\KyogiPlanRequest;
use App\Repositories\Admin\KyogiPlanRepository;
/**
 * サービスクラス
 *
 */
class KyogiPlanService {
    private $repository;
    public function __construct(KyogiPlanRepository $repository){
        $this->repository = $repository;
    }
    
    // 一覧取得
    public function getList(KyogiPlanListRequest $request){
        return $this->repository->getList($request)->ToArray();
    }
    
    // 登録
    public function create(KyogiPlanRequest $request): void{
        $this->repository->create($request);
    }
    
    // 削除
    public function delete($id): void{
        $this->repository->delete($id);
    }
    
    // １件取得
    public function find($id): KyogiPlan{
        return $this->repository->find($id);
    }
    
    // 条件セッション取得
    public function getCondSession(Request $request): array{
        return KyogiPlanListRequest::getRequestSession($request);
    }
    
    // 条件セッションセット
    public function setCondSession(Request $request): void{
        KyogiPlanListRequest::setRequestSession($request);
    }
}
