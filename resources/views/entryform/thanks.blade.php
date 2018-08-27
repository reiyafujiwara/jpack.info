@extends('layout')
@section('title', '申込完了')

    <div class="container clearfix">
        
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <h2>Jボックスお申込完了</h2>
                <form action="{{ route('entryform.thanks') }}" method="post" class="form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  
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
                </form>
            </div>

            <div class="col-xs-8 col-xs-offset-2 text-center entry_status">
                
                <p>入力画面 -> 確認画面　-><span class="label label-danger">完了画面</span>  </p>
            </div>
        </div>
        <div class="row　thanks-msg">
            <div class="col-xs-8 col-xs-offset-2 text-center">
                <h3>お申し込み完了</h3>
                <p class="">
                    Jボックスのお申し込みを頂きましてありがとうございます。<br>
                    こちらでご登録は以上になります。
                </p>
            </div>
        </div>
            
        <div class="row">
            <div style="text-align:center; margin-bottom:20px;" class="col-xs-8 col-xs-offset-2 text-center">
                <a href="https://jpack.info">トップへ戻る</a>
            </div>
        </div>

    </div>

