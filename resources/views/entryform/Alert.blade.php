@extends('layout')
@section('title', 'カードエラー警告')
 
@section('content')

<link href="/css/alertmsg.css" rel="stylesheet" type="text/css">

<div class="container">


    <div class="row">

        <div class="col-xs-10 col-xs-offset-1 ">
            <h2>カード判定エラー</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 alert_box">
            <h3 class="card_alert">クレジットカードがご利用できません。</h3>
            
            <div class="alert_msg">
                <p>お申込頂き、ありがとうございます。</p>
                <p>大変申し訳ありませんが</p>
                <p>ご入力頂いたクレジットカードが利用できない状態でございます。</p>
                <p>下記に決済エラーが出た際に考えられる要因の一部を抜粋しましたので</p>
                <p>再度ご利用カードをご確認の上、ご入力をお願い致します。</p>
            </div>
            
        </div>
        
        <div class="col-xs-8 col-xs-offset-2 errex_box">
            <h4>よくあるクレジットカード決済エラー</h4>
            <ol class="err_list">
                <li>プリベイドカードなどのカード情報を入力している。</li>
                <li>有効期限切れのカードを入力している。</li>
                <li>古いカードを入力している。</li>
                <li>入力したカードが利用停止状態になっている。</li>
                <li>クレジットカードの利用上限枠を超えてしまっている。</li>
            </ol>    
        </div>

        

        
        <p class="col-xs-8 col-xs-offset-2">
            下記のリンクより再度トップページからお申込をお願い致します。
        </p>
        <div style="text-align:center; margin-bottom:20px;" class="col-xs-8 col-xs-offset-2 text-center">
            <a href="https://jpack.info">トップへ戻る</a>
        </div>
    </div>

</div>




