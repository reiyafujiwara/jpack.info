@extends('layout')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>サービス紹介</title>

       

		<!-- Styles -->
       
       
    </head>
    <body>




<div class="container clearfix">
    <div class="row">
         <h2>サービス紹介</h2>
     </div>

    <div class="row">
         <h3 class="service">設定サポート</h3>
         <dl class="center-block max800 service-list">
		<dt class="bg-lightblue">設定お手伝いサービス</dt>
		<dd>
			<p class="detail">専門担当者にてさまざまな設定をお手伝いします。<br>
			例えば・・・セキュリティの設定が分からないとき、使い方が分からないときサポートさせて頂きます。</p>
			<p class="thumb"><img class="img-responsive" src="img/remote.png" alt=""></p>
		</dd>
		<dt class="bg-lightblue">お家かけつけサポートサービス</dt>
		<dd>
			<p class="detail">訪問にてさまざまな設定をお手伝いします。<br>
			例えば・・・パソコンを初期化したい・ネットがつながらないときサポートさせて頂きます。</p>
			<p class="thumb"><img class="img-responsive" src="img/help.png" alt""></p>
		</dd>
		<dt class="bg-lightblue">無償引取サービス</dt>
		<dd>
			<p class="detail">お客様のパソコン、パソコン周辺機器、ご家庭の家電製品を無償でお引取りするサービスです。</p>
			<p class="thumb"><img class="img-responsive" src="img/pc.png" alt=""></p>
		</dd>
	</dl>
     </div>
     
    <div class="row">
         <h3 class="service">軽量化</h3>
         <dl class="center-block service-list-light max800">
		<dt>パソコンを新品のように高速化！</dt>
			<h4 class="center-block max800 download">
				ソフトウェアのダウンロードは<a href="https://jpack.info/download/SystemMechanic_14.0.3.84.exe" style="color:red; font-weight:bold;">こちら</a>から<br />
				<!-- 元ファイルリンクを指定するとエラーになるので除外-->
				<span style="font-size:0.8em;">※ インストール時に必要なシリアル番号は書面にて配布しているＩＤを入力してください。<br />
		※ 動作環境は<a href="">利用規約</a>をご確認下さい。
		<!-- 元ファイルリンクを指定するとエラーになるので除外-->
		</span>
			</h4>
		<dd>
			<p>ライトプランPowered by System mechanicはPCを診断、不具合を修復し、パフォーマンスを最大化するソフトです。</p>
			<div class="row">
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/error.png" alt=""></span><span class="detail-light">エラー、クラッシュ、フリーズを修正</span></div>
				</div>
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/internet.png" alt=""></span><span class="detail-light">インターネットを高速化</span></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/windows.jpg" alt=""></span><span class="detail-light">Windowsの起動時間を短縮</span></div>
				</div>
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/gear.png" alt=""></span><span class="detail-light">システムの安定性を復元</span></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/recycle.png" alt=""></span><span class="detail-light">ゴミおよびジャンクファイルを消去</span></div>
				</div>
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/hourglass.png" alt=""></span><span class="detail-light">低速化とボトルネックを回避</span></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="card"><span class="thumb-light"><img class="img-responsive" src="img/key.png" alt=""></span><span class="detail-light">セキュリティホールをふさぐ 等々</span></div>
				</div>
			</div>
		</dd>
	</dl>
     </div>

    <div class="row">
         <h3 class="service">パソコンソフト使い放題</h3>
         <h4 class="special">120タイトル以上使えてお得</h4>
         <p>有名ブランドの人気ソフトのフル機能版が120タイトル以上収録。</p>
         <h4 class="special">常に最新版</h4>
         <p>アップデートは通常通り受けられますので、新しい機能もすぐに使えます。</p>
         <h4 class="special">使い放題で広がる楽しさ</h4>
         <p>ソフトを使えば、動画や写真の編集、ラベル作成、ホームページ作成などインターネットやメール以外の、パソコンを使う楽しさが広がります。</p>
     </div>
	  <div class="row">
		  <h4>
			  ご利用を開始する方は<a href="http://rd.snxt.jp/46305" target="blank" style="color:red; font-weight:bold;">こちら</a>から 
			  <p style="font-size:0.8em;">
				  ※登録時に必要なシリアル番号は書面にて配布しているIDを入力してください。<br>
				  ※シリアル登録および専門ツールのインストールが完了致しますと下記URLへのリンクのショートカットがデスクトップに表示されます。 　
			 </p>
			  <p><a href="http://rd.snxt.jp/13656" target="blank" style="color:red; font-weight:bold; font-size:0.8em;">http://rd.snxt.jp/13656</a></p>
			  <p>また、対応OSは<a href="http://www.sourcenext.com/" target="blank" style="color:red; font-weight:bold;">ソースネクスト株式会社ホームページ</a>よりご確認お願い致します。</p>
		  </h4>
<div style="text-align:right;">
				<a href="https://jpack.info">トップへ戻る</a>
	</div>
</div>

    </body>
</html>
