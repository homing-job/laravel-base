@inject('consts', 'App\Libs\Consts')

@extends('layouts.content')

@section('content-header')
    <h3>入力情報確認</h3>
@endsection

@section('content')
    <div class="card" style="width:100%">
        <div class="card m-3">
            <div class="card-header">希望競技</div>
            <div class="card-body">
                <table class="responsive table table-striped">
                    <tbody>
                        <tr><th style="background-color: whitesmoke !important;">競技名</th></tr>
                        <tr><td>{{ $kyogi->kyogi_nm }}</td></tr>

                        <tr><th style="background-color: whitesmoke !important;">会場地名</th></tr>
                        <tr><td>{{ $kyogi->address }}</td></tr>

                        <tr><th style="background-color: whitesmoke !important;">競技会場</th></tr>
                        <tr><td>{{ $kyogi->kaizyo_nm }}</td></tr>

                        <tr><th style="background-color: whitesmoke !important;">希望日</th></tr>
                        <tr><td>{{ $input_data['reception']['kyogi_hope_date'] }}</td></tr>
                </table>
            </div>
        </div>

        <!-- 代表者 -->
        @include('content.include.confirmation_member', ['title' => '代表者', 'reception_member' => $input_data['reception_members'][0]])

        <!-- 申込者 -->
        @for ($i = 1; $i < count($input_data['reception_members']); $i++)
            @include('content.include.confirmation_member', ['title' => '申込者', 'reception_member' => $input_data['reception_members'][$i]])
        @endfor

        <!-- 管理画面から詳細確認時は表示させない -->
        @if(!$is_admin)
            <button type="button" class="btn btn-secondary" onclick="history.back();">入力画面に戻る</button>
            <button type="button" class="btn btn-success" onclick="submit()">確定</button>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{ mix('js/confirmation.js') }}" defer></script>
@endsection

@section('css')
@endsection
