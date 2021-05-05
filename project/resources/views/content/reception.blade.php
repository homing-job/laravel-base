@inject('kyogi', 'App\Models\Kyogi')

@extends('layouts.content')

@section('content-header')
    <h3>参加競技情報の入力</h3>
@endsection

@section('content')
    <reception-component></reception-component>
@endsection

@section('js')
    <script src="{{ mix('js/reception.js') }}" defer></script>
@endsection

@section('css')
    <link href="{{ mix('css/reception.css') }}" rel="stylesheet">
@endsection
