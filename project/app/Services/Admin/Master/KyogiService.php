<?php

namespace App\Services\Admin\Master;

use Illuminate\Http\Request;
use App\Models\Kyogi;
use App\Http\Requests\Admin\Master\KyogiListRequest;
use App\Http\Requests\Admin\Master\KyogiRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Excel\Exports\KyogisExport;
use App\Repositories\Admin\Master\KyogiRepository;

/**
 * サービスクラス
 *
 */
class KyogiService {
    private $repository;
    public function __construct(KyogiRepository $repository){
        $this->repository = $repository;
    }
    
    // 一覧取得
    public function getList(KyogiListRequest $request): array{
        return $this->repository->getList($request)->toArray();
    }
    
    // 登録
    public function create(KyogiRequest $request){
        $this->repository->create($request);
    }
    
    // 削除
    public function delete(string $id): array{
        $result['success'] = false;
        // 削除可能チェック
        $kyogi = $this->repository->find($id);
        // 子テーブルに有効なデータが存在する場合は削除しない。
        if($kyogi->receptions->isEmpty() && $kyogi->kyogiPlans->isEmpty()){
            $this->repository->delete($id);
            $result['success'] = true;
        }
        return $result;
    }
    
    // 更新
    public function update(KyogiRequest $request, string $id): void{
        $this->repository->update($request, $id);
    }
    
    // １件取得
    public function find(string $id): Kyogi{
        return $this->repository->find($id);
    }
    
    // 条件セッション取得
    public function getCondSession(Request $request): array{
        return KyogiListRequest::getRequestSession($request);
    }
    
    // 条件セッションセット
    public function setCondSession(Request $request): void{
        KyogiListRequest::setRequestSession($request);
    }
    
    // excel出力
    public function exportExcel(){
        return Excel::download(new KyogisExport, 'kyogis.xlsx');
    }
}
