<?php

namespace App\Repositories\Admin\Master;

use App\Models\Kyogi;
use App\Http\Requests\Admin\Master\KyogiListRequest;
use App\Http\Requests\Admin\Master\KyogiRequest;
use Illuminate\Database\Eloquent\Collection;

/**
 * リポジトリクラス
 *
 */
class KyogiRepository {
    // 一覧取得
    public function getList(KyogiListRequest $request): Collection{
        return Kyogi::where($request->filters())
                        ->orderBy('kyogi_nm')
                        ->orderBy('kaizyo_nm')
                        ->get();
    }
    
    // 登録
    public function create(KyogiRequest $request): void{
        Kyogi::create($request->all());
    }
    
    // 削除
    public function delete($id): void{
        Kyogi::where('id', $id)->delete();
    }
    
    // 更新
    public function update(KyogiRequest $request, string $id): void{
        $update = [
            'kyogi_nm' => $request->kyogi_nm,
            'address' => $request->address,
            'kaizyo_nm' => $request->kaizyo_nm
        ];
        Kyogi::where('id', $id)->update($update);
    }
    
    // １件取得
    public function find(string $id): Kyogi{
        return Kyogi::find($id);
    }
}
