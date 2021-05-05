<?php

namespace Tests\Unit;

use App\Models\General;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

// 汎用マスタモデルテスト
class GeneralModelTest extends TestCase
{   
    /**
     * 連番更新テスト
     *
     * @return void
     */
    public function testSequenceUpdate()
    {
        $data = General::factory()->create(['value' => 1]);
        $general = new General();
        $general->sequenceUpdate($data->kbn);
        $this->assertTrue(General::find($data->id)->value == 2);
        $general->sequenceUpdate($data->kbn);
        $this->assertTrue(General::find($data->id)->value == 3);
        $general->sequenceUpdate($data->kbn);
        $this->assertTrue(General::find($data->id)->value == 4);
    }
}
