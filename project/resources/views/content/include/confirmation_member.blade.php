@inject('Consts', 'App\Libs\Consts')

<div class="card m-3">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        <table class="responsive table table-striped">
            <tbody>
                <tr><th style="background-color: whitesmoke !important;">氏名</th></tr>
                <tr><td>{{ $reception_member['first_nm'] }} {{ $reception_member['last_nm'] }}</td></tr>

                <tr><th style="background-color: whitesmoke !important;">フリガナ</th></tr>
                <tr><td>{{ $reception_member['first_nm_kana'] }} {{ $reception_member['last_nm_kana'] }}</td></tr>

                <tr><th style="background-color: whitesmoke !important;">性別</th></tr>
                <tr><td>{{ $Consts::getValue('sex', $reception_member['sex']) }}</td></tr>

                <tr><th style="background-color: whitesmoke !important;">生年月日</th></tr>
                <tr><td>{{ $reception_member['birthday_year'] }}年{{ $reception_member['birthday_month'] }}月{{ $reception_member['birthday_day'] }}日</td></tr>

                <tr><th style="background-color: whitesmoke !important;">郵便番号</th></tr>
                <tr><td>{{ $reception_member['post_cd'] }}</td></tr>

                <tr><th style="background-color: whitesmoke !important;">住所</th></tr>
                <tr><td>{{ $Consts::getValue('prefectures', $reception_member['prefectures_cd']) }}{{ $reception_member['address1'] }}{{ $reception_member['address2'] }}</td></tr>

                <tr><th style="background-color: whitesmoke !important;">携帯電話番号</th></tr>
                <tr><td>{{ $reception_member['tel_keitai'] }}</td></tr>

                <tr><th style="background-color: whitesmoke !important;">自宅電話番号等</th></tr>
                <tr><td>{{ $reception_member['tel_zitaku'] }}</td></tr>

                @if($reception_member['is_daihyo'])
                    <tr><th style="background-color: whitesmoke !important;">要望</th></tr>
                    <tr><td>{{ $reception_member['hope'] }}</td></tr>

                    <tr><th style="background-color: whitesmoke !important;">メールアドレス</th></tr>
                    <tr><td>{{ $reception_member['email'] }}</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
