@extends('layout')
@section('title', 'Jボックス申込確認')
<script src="https://pt01.mul-pay.jp/ext/js/token.js" ></script>
{{-- <script src="https://p01.mul-pay.jp/ext/js/token.js" ></script> --}}
@section('content')
<div class="container">


<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <h2>入力内容確認画面</h2>
    </div>



 
<form action="{{ route('entryform.thanks') }}" method="post" class="form-horizontal">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  {{-- <input type="hidden" name="OrderID" value="{{$OrderID}}"> --}}
  <input type="hidden" name="name1" value="{{$name1}}">
  <input type="hidden" name="name2" value="{{$name2}}">
  <input type="hidden" name="kana1" value="{{$kana1}}">
  <input type="hidden" name="kana2" value="{{$kana2}}">
  <input type="hidden" name="sex" value="{{$sex}}">
  <input type="hidden" name="tel" value="{{$tel}}">
  <input type="hidden" name="zipcode1" value="{{$zipcode1}}">
  <input type="hidden" name="zipcode2" value="{{$zipcode2}}">
  <input type="hidden" name="address1" value="{{$address1}}">
  <input type="hidden" name="address2" value="{{$address2}}">
  <input type="hidden" name="address3" value="{{$address3}}">
  <input type="hidden" name="birthday_year" value="{{$birthday_year}}">
  <input type="hidden" name="birthday_month" value="{{$birthday_month}}">
  <input type="hidden" name="birthday_day" value="{{$birthday_day}}">
  <input type="hidden" name="credit_num" value="{{$credit_num}}">
  <input type="hidden" name="credit_name" value="{{$credit_name}}">
  <input type="hidden" name="expiration_date_month" value="{{$expiration_date_month}}">
  <input type="hidden" name="expiration_date_year" value="{{$expiration_date_year}}">
  <input type="hidden" name="credit_token" id="credit_token" value="{{$credit_token}}">
</div>
 
  <div class="table-responsive">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 text-center entry_status">
            <p>入力画面 -> <span class="label label-danger">確認画面</span> -> 完了画面</p>
        </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3 confirm_message">
        <h4>入力内容確認</h4>
        <p>
          ご入力内容頂いた内容を表示しています。<br>
          ご入力内容をご確認の上、お間違いがなければ登録ボタンを押して下さい。
        </p>
      </div>
    </div>
    <div class="row col-xs-10 col-xs-offset-1">
    <table class="table">
      <thead>
        <tr>
          <th class="col-xs-3 text-right">入力項目:</th>
          <th>入力内容</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <th class="col-xs-5 text-right">名前：</th>
            <td>{{$name1}}{{$name2}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">フリガナ：</th>
          <td>{{$kana1}}{{$kana2}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">性別：</th>
          <td>{{$sex}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">電話番号：</th>
          <td>{{$tel}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">郵便番号：</th>
          <td>{{$zipcode1}}-{{$zipcode2}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">住所：</th>
          <td>{{$address1}}{{$address2}}{{$address3}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">生年月日：</th>
          <td>{{$birthday_year}}年{{$birthday_month}}月{{$birthday_day}}日</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">クレジットカード番号：</th>
          <td>{{$credit_num}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">クレジットカード名義：</th>
          <td>{{$credit_name}}</td>
        </tr>
        <tr>
          <th class="col-xs-5 text-right">クレジットカード有効期限：</th>
          <td>{{$expiration_date_month}}月/{{$expiration_date_year}}年</td>
        </tr>
      </tbody>
    </table>
  </div>
      <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
            <input type="submit" name="action" value="入力画面に戻る" class="btn btn-warning btn-wide btn-lg pull-left col-xs-4"/>
            <input type="submit" name="action" value="登録する" class="btn btn-primary btn-wide btn-lg pull-right col-xs-4"/>
          </div>
        </div>
    </div>
  </div>
</form>
<script type="text/javascript">

  window.onload = TokenIssue();

    function TokenIssue(){
        // console.log('ok')
        Multipayment.init("tshop00033421");
        // Multipayment.init("9100523834716");
        Multipayment.getToken({
            cardno : {{$credit_num}},
            expire : {{$expiration_date_year}}{{$expiration_date_month}}
        },TokenInput);
        // console.log(Multipayment);

    }
      

    function TokenInput(response){
        // console.log(response.tokenObject.token);
        document.getElementById("credit_token").value = response.tokenObject.token;
        // window.alert(response);
      
    }




  </script>