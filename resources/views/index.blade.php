@extends('layout')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
       
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>トップページ</title>


        <!-- Styles -->
        <link rel="stylesheet" href="/public/css/base.css">
        <link rel="stylesheet" href="/public/css/style.css">
        
    </head>
    <body>
        <div class="container clearfix">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 text-center">
                    <h1 class="title-text">各種お申込み</h1>
                </div>
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-design">
                        <div class="panel-heading">
                            <h5 class="panel-title">Jボックス</h5>
                        </div>
                        <div class="panel-body">
                            <p>
                                <img src="img/jbox_img-1.jpg" alt="Jボックス">
                            </p>
                            <div class="pull-left">
                                <p class="price-text">月額 2,300<span class="price-text-small">円(税抜)</span></p>
                                <p>サービス概要は<a href="/service">こちら</a></p>
                                <p class="accent-text">※最大20日無料</p>
                            </div>
                            <div class="pull-right col-xs-8 col-sm-3">
                                <button class="btn btn-lg btn-design" data-featherlight="#applicationBox" type="submit">お申込み</button>                </div>
                        </div>
                        <div class="lightbox" id="applicationBox">
                            <div class="alert-title clearfix">
                                <img src="img/alert.svg" alt="お申込前ご確認" class="warning-alert pull-left">
                                <h3 class="pull-left clearfix">お申込前にご確認ください</h3>
                            </div>
                            <h4>利用規約</h4>
                            <div class="alert-contents">
                                @include('terms')
                            </div>
                            <h4>プライバシーポリシー</h4>
                            <div class="alert-contents">
                                @include('privacy')
                            </div>
                            <div class="col-xs-12 lightbox-btn">
                                <a href="/contact" class="btn btn-lg btn-design">上記に同意してお申込み</a>
                            </div>
                        </div>
                        <div class="panel-footer" style="text-align: right;">
                            <a href="/asct">特定商取引法に基づく表記</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
