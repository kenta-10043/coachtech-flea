@extends('layouts.auth')
@section('css')
    <link rel="stylesheet" href="{{ 'css/emails/item_confirmed.css' }}">
@endsection

@section('content')
    <p>{{$user->name}}様</p>

    <p>以下の商品の販売が確定いたしました。</p>

    <p>商品名：{{$item->item_name}}</p>
    <p>価格：￥{{number_format($item->price)}}</p>

    <p>チャット画面から評価入力を行い売買を確定してください。</p>

@endsection
