@extends('layout')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Jボックスお申込フォーム</title>


        <!-- Styles -->
        <link rel="stylesheet" href="/public/style.css">
        
    </head>
    <body>
    <div class="container clearfix">
        
<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <h2>Jボックスお申込フォーム</h2>
    </div>
    <div class="col-xs-10 col-xs-offset-1">


	<div class="alert alert-danger">

		<p class="text-center"></p>

	</div>
	<div class="alert alert-success">
		<p class="text-center"></p>
	</div>
	<form action="" id="form" class="entry-form" method="post" role="form">
<input type="hidden" name="type" value="Jボックス">
<!--
    <input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
    上記csrf_keyを認識してErrorException (E_ERROR)が起きる。
-->
        <div class="form-group col-xs-12">
            <div class="input text required">
					<label class="mark-require" for="name">氏名</label>
				</div>
				<div class="col-xs-1 padding-none form-lavel-position">姓</div>				
				<div class="col-xs-10 col-sm-4">
					<input type="text" name="name1" class="form-control" placeholder="例)山田" required="required" maxlength="30" id="name1" value="">
				</div>
				<div class="col-xs-1 padding-none form-lavel-position">名</div>
				<div class="col-xs-10 col-sm-4">
					<input type="text" name="name2" class="form-control" placeholder="例)太郎" required="required" maxlength="30" id="name2" value="">
				</div>
			</div>
        <div class="form-group col-xs-12">
				<div class="input text required">
					<label class="mark-require" for="kana">フリガナ[カタカナ全角]</label>
				</div>
				<div class="col-xs-1 padding-none form-lavel-position">姓</div>				
				<div class="col-xs-10 col-sm-4">
					<input type="text" name="kana1" class="form-control" placeholder="例)ヤマダ" required="required" maxlength="30" id="kana1" value="">
				</div>
				<div class="col-xs-1 padding-none form-lavel-position">名</div>
				<div class="col-xs-10 col-sm-4">
					<input type="text" name="kana2" class="form-control" placeholder="例)タロウ" required="required" maxlength="30" id="kana2" value="">
				</div>
			</div>
        <div class="form-group col-xs-12 col-sm-6">
            <div class="input select required"><label class="mark-require" for="sex">性別</label>
					<select name="sex" between="<div class=&quot;form-group col-xs-12&quot;>" class="form-control" required="required" id="sex">
						<option value="男性">男性</option>
						<option value="女性">女性</option>
					</select>
				</div>
			</div>
        <div class="form-group col-xs-12">
            <div class="input tel required">
					<label class="mark-require" for="tel">連絡先[半角ハイフンなし]</label>
					<input type="tel" name="tel" class="form-control" placeholder="0312345678" required="required" maxlength="15" pattern="^[0-9]+$" id="tel">
				</div>
			</div>
        <div class="form-group col-xs-12 col-sm-6">
            <div class="input text required">
					<label class="mark-require" for="zipcode">郵便番号</label>
				</div>
				<div class="col-xs-10 col-sm-3">
					<input type="text" name="zipcode1" class="form-control" placeholder="123" id="zipcode1" pattern="^[0-9]+$" maxlength="3">
				</div>
				<div class="col-xs-1 form-lavel-position padding-none">-</div>
				<div class="col-xs-10 col-sm-3">
					<input type="text" name="zipcode2" class="form-control" placeholder="4567" id="zipcode2"  pattern="^[0-9]+$" maxlength="4"  onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','address1','address1');">
				</div>
			</div>
        <div class="form-group col-xs-12">
            <div class="input text required">
					<label class="mark-require" for="address">住所(市・区・郡及び町村名)</label>
					<input type="text" name="address1" class="form-control" placeholder="東京都新宿区〇〇" required="required" maxlength="100" id="address">
				</div>
			</div>
			<div class="form-group col-xs-12">
            <div class="input text required">
					<label class="mark-require" for="address">住所（丁目・番地）[半角]</label>
					<input type="text" name="address2" class="form-control" placeholder="1−1−1" required="required" maxlength="100" id="address">
				</div>
			</div>
			<div class="form-group col-xs-12">
            <div class="input text required">
					<label class="" for="address">住所(建物名・部屋番号)</label>
					<input type="text" name="address3" class="form-control" placeholder="マンション名1" maxlength="100" id="address">
				</div>
			</div>
        <div class="form-group col-xs-12">
            <div class="mark-require">
                <label for="birthday">生年月日</label>
				</div>
            <div class="col-xs-10 col-sm-2">
					<select name="birthday-year" class="form-control require">
						<option value=""></option>
						<option value="2000">2000</option>
						<option value="1999">1999</option>
						<option value="1998">1998</option>
						<option value="1997">1997</option>
						<option value="1996">1996</option>
						<option value="1995">1995</option>
						<option value="1994">1994</option>
						<option value="1993">1993</option>
						<option value="1992">1992</option>
						<option value="1991">1991</option>
						<option value="1990">1990</option>
						<option value="1989">1989</option>
						<option value="1988">1988</option>
						<option value="1987">1987</option>
						<option value="1986">1986</option>
						<option value="1985">1985</option>
						<option value="1984">1984</option>
						<option value="1983">1983</option>
						<option value="1982">1982</option>
						<option value="1981">1981</option>
						<option value="1980">1980</option>
						<option value="1979">1979</option>
						<option value="1978">1978</option>
						<option value="1977">1977</option>
						<option value="1976">1976</option>
						<option value="1975">1975</option>
						<option value="1974">1974</option>
						<option value="1973">1973</option>
						<option value="1972">1972</option>
						<option value="1971">1971</option>
						<option value="1970">1970</option>
						<option value="1969">1969</option>
						<option value="1968">1968</option>
						<option value="1967">1967</option>
						<option value="1966">1966</option>
						<option value="1965">1965</option>
						<option value="1964">1964</option>
						<option value="1963">1963</option>
						<option value="1962">1962</option>
						<option value="1961">1961</option>
						<option value="1960" selected="selected">1960</option>
						<option value="1959">1959</option>
						<option value="1958">1958</option>
						<option value="1957">1957</option>
						<option value="1956">1956</option>
						<option value="1955">1955</option>
						<option value="1954">1954</option>
						<option value="1953">1953</option>
						<option value="1952">1952</option>
						<option value="1951">1951</option>
						<option value="1950">1950</option>
						<option value="1949">1949</option>
						<option value="1948">1948</option>
						<option value="1947">1947</option>
						<option value="1946">1946</option>
						<option value="1945">1945</option>
						<option value="1944">1944</option>
						<option value="1943">1943</option>
						<option value="1942">1942</option>
						<option value="1941">1941</option>
						<option value="1940">1940</option>
						<option value="1939">1939</option>
						<option value="1938">1938</option>
						<option value="1937">1937</option>
						<option value="1936">1936</option>
						<option value="1935">1935</option>
						<option value="1934">1934</option>
						<option value="1933">1933</option>
						<option value="1932">1932</option>
						<option value="1931">1931</option>
						<option value="1930">1930</option>
						<option value="1929">1929</option>
						<option value="1928">1928</option>
						<option value="1927">1927</option>
						<option value="1926">1926</option>
						<option value="1925">1925</option>
						<option value="1924">1924</option>
						<option value="1923">1923</option>
						<option value="1922">1922</option>
						<option value="1921">1921</option>
						<option value="1920">1920</option>
					</select> 
            </div>
            <div class="col-xs-1 padding-none form-lavel-position">年</div> 
            <div class="col-xs-10 col-sm-2">
					<select name="birthday-month" class="form-control require">
						<option value="" selected="selected"></option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
					</select>
				</div>
            <div class="col-xs-1 padding-none form-lavel-position">月</div>
            <div class="col-xs-10 col-sm-2">
					<select name="birthday-day" class="form-control require">
						<option value="" selected="selected"></option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
					</select>
				</div>
            <div class="col-xs-1 padding-none form-lavel-position">日</div>
        </div>
			<div class="form-group col-xs-12">
				<div class="">
                <label for="credit">利用可能なクレジットカード</label>
				</div>
            <p>
				VISA、JCB、MasterCard、AMEX、Diners<br />
				<span style="font-size:0.9em;">※デビットカードはご利用いただけません</span>
				<p>
			</div>
        <div class="form-group col-xs-12">
            <div class="input text required">
					<label class="mark-require" for="credit-num">クレジットカード番号</label>
						<input type="text" name="credit-num" class="form-control" required="required" minlength="14" maxlength="16" id="credit-num"  pattern="^[0-9]+$" >
				</div>
			</div>
        <div class="form-group col-xs-12">
            <div class="input text required"><label class="mark-require" for="credit-name">クレジットカード名義(半角英数字)</label>
					<input type="text" name="credit-name" placeholder="例)TARO YAMADA"  class="form-control" required="required" maxlength="100" id="credit-name" pattern="^[0-9A-Za-z| ]+$" >
				</div>
        </div>
        <div class="form-group col-xs-12">
            <div class="required mark-require">
                <label for="expiration-date">クレジットカード有効期限</label>
				</div>
            <div class="col-xs-2">
					<select name="expiration_date-month" class="form-control">
						<option value=""></option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04" >4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
					</select>
				</div>
            <div class="col-xs-1 padding-none form-lavel-position">
                月
            </div>
            <div class="col-xs-2">
               <select name="expiration_date-year" class="form-control">
					<option value=""></option><option value="2026">2026</option><option value="2025">2025</option><option value="2024">2024</option><option value="2023">2023</option><option value="2022">2022</option><option value="2021">2021</option><option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option>
					</select>
				</div>
            <div class="col-xs-1 padding-none form-lavel-position">
                年
            </div>
        </div>
        <div class="form-group col-sm-6 col-sm-offset-3">
            <button class="btn btn-design submit" type="submit">登録する</button>        </div>
    </form>
			</div>
</div>
<div style="text-align:right;">
				<a href="https://jpack.info">トップへ戻る</a>
</div>
</div>

    </body>
</html>
