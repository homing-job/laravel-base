<?php

namespace App\Excel\Exports;

use App\Models\Kyogi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

// 競技マスタデータ出力
class KyogisExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents{
    // 出力ファイル中身
    public function collection(){
        return Kyogi::all();
    }
    
    // ヘッダ
    public function headings():array{
        return ['id', 
                'kyogi_nm', 
                'address', 
                'kaizyo_nm', 
                'created_at',
                'updated_at',
                'deleted_at',];
    }
    
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // 出力後に、全セルの書式を文字列に変更する
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            },
        ];
    }
}