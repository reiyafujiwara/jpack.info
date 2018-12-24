<!DOCTYPE html>
<head>
	@extends('layout')
	@section('title','Jボックス申込フォーム')

</head>



@section('content')
	<div class="container clearfix">
	
        
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 ">
				<h2>Jボックスお申込フォーム</h2>
			</div>
            <div class="col-xs-10 col-xs-offset-1  text-center entry_status">
                <p><span class="label label-danger">入力画面</span> -> 確認画面 -> 完了画面</p>
			</div>
			
			
			@if ($errors->any())
				<div class="errors col-xs-10 col-xs-offset-1 ">
					<h3>入力エラー</h3>
					<p>
						下記項目にて、入力内容もしくは入力形式が正しくありません。<br>
						入力内容をご確認頂き、再度ご入力をお願い致します。
					</p>
					<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			@endif
			
			
			<div class="col-xs-10 col-xs-offset-1">

			<form action="{{route('entryform.confirm')}}" id="form" class="entry-form" method="post" role="form">
				<input type="hidden" name="type" value="Jボックス">
				<input type="hidden" name="confirming" value="{{ old('confirming', 'false') }}")>
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" name="OrderID" value="{{$OrderID}}">
				


				<div class="form-group col-xs-12">
					<div class="input text required">
						<label class="mark-require" for="name">氏名</label>
					</div>
					<div class="col-xs-2 col-sm-1 padding-none form-lavel-position">姓</div>				
					<div class="col-xs-10 col-sm-4">
						<input type="text" name="name1" class="form-control" placeholder="例)山田" required="required" maxlength="30" id="name1" value="{{ old('name1')}}">
					</div>
					<div class="col-xs-2 col-sm-1 padding-none form-lavel-position">名</div>
					<div class="col-xs-10 col-sm-4">
						<input type="text" name="name2" class="form-control" placeholder="例)太郎" required="required" maxlength="30" id="name2" value="{{ old('name2')}}">
					</div>
				</div>
				<div class="form-group col-xs-12">
						<div class="input text required">
							<label class="mark-require" for="kana">フリガナ[カタカナ全角]</label>
						</div>
						<div class="col-xs-2 col-sm-1 padding-none form-lavel-position">セイ</div>				
						<div class="col-xs-10 col-sm-4">
							<input type="text" name="kana1" class="form-control" placeholder="例)ヤマダ" required="required" maxlength="30" id="kana1" value="{{ old('kana1')}}">
						</div>
						<div class="col-xs-2 col-sm-1 padding-none form-lavel-position">メイ</div>
						<div class="col-xs-10 col-sm-4">
							<input type="text" name="kana2" class="form-control" placeholder="例)タロウ" required="required" maxlength="30" id="kana2" value="{{ old('kana2')}}">

						</div>
					</div>
				<div class="form-group col-xs-12 col-sm-6">
					<div class="input select required "><label class="mark-require" for="sex">性別</label>
							<select name="sex" between="<div class=&quot;form-group col-xs-10&quot;>" class="form-control" required="required" id="sex">
								<option value="" selected="selected">未選択</option>
								<option value="男性" @if(old('sex')=='男性') selected @endif>男性</option>
								<option value="女性" @if(old('sex')=='女性') selected @endif>女性</option>
							</select>
						</div>
					</div>
				<div class="form-group col-xs-12">
					<div class="input tel required">
							<label class="mark-require" for="tel">連絡先[半角ハイフンなし]</label>
							<input type="tel" name="tel" class="form-control" placeholder="0312345678" required="required" maxlength="15" pattern="^[0-9]+$" id="tel" value="{{ old('tel')}}">

						</div>
					</div>
				<div class="form-group col-xs-12 col-sm-6">
					<div class="input text required">
							<label class="mark-require" for="zipcode">郵便番号</label>
						</div>
						<div class="col-xs-10 col-sm-3">
							<input type="text" name="zipcode1" class="form-control" placeholder="123" id="zipcode1" pattern="^[0-9]+$" maxlength="3" value="{{ old('zipcode1')}}">

						</div>
						<div class="col-xs-1 form-lavel-position padding-none">-</div>
						<div class="col-xs-10 col-sm-3">
							<input type="text" name="zipcode2" class="form-control" placeholder="4567" id="zipcode2"  pattern="^[0-9]+$" maxlength="4"  onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','address1','address1');" value="{{ old('zipcode2')}}">

						</div>
					</div>
				<div class="form-group col-xs-12">
					<div class="input text required">
							<label class="mark-require" for="address">住所(市・区・郡及び町村名)</label>
							<input type="text" name="address1" class="form-control" placeholder="東京都新宿区〇〇" required="required" maxlength="100" id="address" value="{{ old('address1')}}">
                            @if($errors->has('zipcode2'))
                            <span class="text-danger">{{ $errors->first('zipcode2') }}</span>
                             @endif
						</div>
					</div>
					<div class="form-group col-xs-12">
					<div class="input text required">
							<label class="mark-require" for="address">住所（丁目・番地）[半角]</label>
							<input type="text" name="address2" class="form-control" placeholder="1−1−1" required="required" maxlength="100" id="address" value="{{ old('address2')}}">
						</div>
					</div>
					<div class="form-group col-xs-12">
					<div class="input text required">
							<label class="" for="address">住所(建物名・部屋番号)</label>
							<input type="text" name="address3" class="form-control" placeholder="マンション名1" maxlength="100" id="address" value="{{ old('address3')}}">
						</div>
					</div>
				<div class="form-group col-xs-12">
					<div class="mark-require">
						<label for="birthday">生年月日</label>
						</div>
					<div class="col-xs-10 col-sm-2">
							<select name="birthday_year" class="form-control require" value="birthday_year">
								<option value="" selected="selected">未選択</option>
								<option value="2000" @if(old('birthday_year')=='2000') selected @endif>2000</option>
								<option value="1999" @if(old('birthday_year')=='1999') selected @endif>1999</option>
								<option value="1998" @if(old('birthday_year')=='1998') selected @endif>1998</option>
								<option value="1997" @if(old('birthday_year')=='1997') selected @endif>1997</option>
								<option value="1996" @if(old('birthday_year')=='1996') selected @endif>1996</option>
								<option value="1995" @if(old('birthday_year')=='1995') selected @endif>1995</option>
								<option value="1994" @if(old('birthday_year')=='1994') selected @endif>1994</option>
								<option value="1993" @if(old('birthday_year')=='1993') selected @endif>1993</option>
								<option value="1992" @if(old('birthday_year')=='1992') selected @endif>1992</option>
								<option value="1991" @if(old('birthday_year')=='1991') selected @endif>1991</option>
								<option value="1990" @if(old('birthday_year')=='1990') selected @endif>1990</option>
								<option value="1989" @if(old('birthday_year')=='1989') selected @endif>1989</option>
								<option value="1988" @if(old('birthday_year')=='1988') selected @endif>1988</option>
								<option value="1987" @if(old('birthday_year')=='1987') selected @endif>1987</option>
								<option value="1986" @if(old('birthday_year')=='1986') selected @endif>1986</option>
								<option value="1985" @if(old('birthday_year')=='1985') selected @endif>1985</option>
								<option value="1984" @if(old('birthday_year')=='1984') selected @endif>1984</option>
								<option value="1983" @if(old('birthday_year')=='1983') selected @endif>1983</option>
								<option value="1982" @if(old('birthday_year')=='1982') selected @endif>1982</option>
								<option value="1981" @if(old('birthday_year')=='1981') selected @endif>1981</option>
								<option value="1980" @if(old('birthday_year')=='1980') selected @endif>1980</option>
								<option value="1979" @if(old('birthday_year')=='1979') selected @endif>1979</option>
								<option value="1978" @if(old('birthday_year')=='1978') selected @endif>1978</option>
								<option value="1977" @if(old('birthday_year')=='1977') selected @endif>1977</option>
								<option value="1976" @if(old('birthday_year')=='1976') selected @endif>1976</option>
								<option value="1975" @if(old('birthday_year')=='1975') selected @endif>1975</option>
								<option value="1974" @if(old('birthday_year')=='1974') selected @endif>1974</option>
								<option value="1973" @if(old('birthday_year')=='1973') selected @endif>1973</option>
								<option value="1972" @if(old('birthday_year')=='1972') selected @endif>1972</option>
								<option value="1971" @if(old('birthday_year')=='1971') selected @endif>1971</option>
								<option value="1970" @if(old('birthday_year')=='1970') selected @endif>1970</option>
								<option value="1969" @if(old('birthday_year')=='1969') selected @endif>1969</option>
								<option value="1968" @if(old('birthday_year')=='1968') selected @endif>1968</option>
								<option value="1967" @if(old('birthday_year')=='1967') selected @endif>1967</option>
								<option value="1966" @if(old('birthday_year')=='1966') selected @endif>1966</option>
								<option value="1965" @if(old('birthday_year')=='1965') selected @endif>1965</option>
								<option value="1964" @if(old('birthday_year')=='1964') selected @endif>1964</option>
								<option value="1963" @if(old('birthday_year')=='1963') selected @endif>1963</option>
								<option value="1962" @if(old('birthday_year')=='1962') selected @endif>1962</option>
								<option value="1961" @if(old('birthday_year')=='1961') selected @endif>1961</option>
								<option value="1960" @if(old('birthday_year')=='1960') selected @endif>1960</option>
								<option value="1959" @if(old('birthday_year')=='1959') selected @endif>1959</option>
								<option value="1958" @if(old('birthday_year')=='1958') selected @endif>1958</option>
								<option value="1957" @if(old('birthday_year')=='1957') selected @endif>1957</option>
								<option value="1956" @if(old('birthday_year')=='1956') selected @endif>1956</option>
								<option value="1955" @if(old('birthday_year')=='1955') selected @endif>1955</option>
								<option value="1954" @if(old('birthday_year')=='1954') selected @endif>1954</option>
								<option value="1953" @if(old('birthday_year')=='1953') selected @endif>1953</option>
								<option value="1952" @if(old('birthday_year')=='1952') selected @endif>1952</option>
								<option value="1951" @if(old('birthday_year')=='1951') selected @endif>1951</option>
								<option value="1950" @if(old('birthday_year')=='1950') selected @endif>1950</option>
								<option value="1949" @if(old('birthday_year')=='1949') selected @endif>1949</option>
								<option value="1948" @if(old('birthday_year')=='1948') selected @endif>1948</option>
								<option value="1947" @if(old('birthday_year')=='1947') selected @endif>1947</option>
								<option value="1946" @if(old('birthday_year')=='1946') selected @endif>1946</option>
								<option value="1945" @if(old('birthday_year')=='1945') selected @endif>1945</option>
								<option value="1944" @if(old('birthday_year')=='1944') selected @endif>1944</option>
								<option value="1943" @if(old('birthday_year')=='1943') selected @endif>1943</option>
								<option value="1942" @if(old('birthday_year')=='1942') selected @endif>1942</option>
								<option value="1941" @if(old('birthday_year')=='1941') selected @endif>1941</option>
								<option value="1940" @if(old('birthday_year')=='1940') selected @endif>1940</option>
							</select> 
					</div>
					<div class="col-xs-1 padding-none form-lavel-position">年</div> 
					<div class="col-xs-10 col-sm-2">
							<select name="birthday_month" class="form-control require" value="birthday_month">
								<option value="" selected="selected">未選択</option>
								<option value="01" @if(old('birthday_month')=='01') selected @endif>1</option>
								<option value="02" @if(old('birthday_month')=='02') selected @endif>2</option>
								<option value="03" @if(old('birthday_month')=='03') selected @endif>3</option>
								<option value="04" @if(old('birthday_month')=='04') selected @endif>4</option>
								<option value="05" @if(old('birthday_month')=='05') selected @endif>5</option>
								<option value="06" @if(old('birthday_month')=='06') selected @endif>6</option>
								<option value="07" @if(old('birthday_month')=='07') selected @endif>7</option>
								<option value="08" @if(old('birthday_month')=='08') selected @endif>8</option>
								<option value="09" @if(old('birthday_month')=='09') selected @endif>9</option>
								<option value="10" @if(old('birthday_month')=='10') selected @endif>10</option>
								<option value="11" @if(old('birthday_month')=='11') selected @endif>11</option>
								<option value="12" @if(old('birthday_month')=='12') selected @endif>12</option>
							</select>
					</div>
					<div class="col-xs-1 padding-none form-lavel-position">月</div>
					<div class="col-xs-10 col-sm-2">
						<select name="birthday_day" class="form-control require">
							<option value="" selected="selected">未選択</option>
							<option value="01" @if(old('birthday_day')=='01') selected @endif>1</option>
							<option value="02" @if(old('birthday_day')=='02') selected @endif>2 </option>
							<option value="03" @if(old('birthday_day')=='03') selected @endif>3 </option>
							<option value="04" @if(old('birthday_day')=='04') selected @endif>4 </option>
							<option value="05" @if(old('birthday_day')=='05') selected @endif>5 </option>
							<option value="06" @if(old('birthday_day')=='06') selected @endif>6 </option>
							<option value="07" @if(old('birthday_day')=='07') selected @endif>7 </option>
							<option value="08" @if(old('birthday_day')=='08') selected @endif>8 </option>
							<option value="09" @if(old('birthday_day')=='09') selected @endif>9 </option>
							<option value="10" @if(old('birthday_day')=='10') selected @endif>1 0</option>
							<option value="11" @if(old('birthday_day')=='11') selected @endif>1 1</option>
							<option value="12" @if(old('birthday_day')=='12') selected @endif>1 2</option>
							<option value="13" @if(old('birthday_day')=='13') selected @endif>1 3</option>
							<option value="14" @if(old('birthday_day')=='14') selected @endif>1 4</option>
							<option value="15" @if(old('birthday_day')=='15') selected @endif>1 5</option>
							<option value="16" @if(old('birthday_day')=='16') selected @endif>1 6</option>
							<option value="17" @if(old('birthday_day')=='17') selected @endif>1 7</option>
							<option value="18" @if(old('birthday_day')=='18') selected @endif>1 8</option>
							<option value="19" @if(old('birthday_day')=='19') selected @endif>1 9</option>
							<option value="20" @if(old('birthday_day')=='20') selected @endif>2 0</option>
							<option value="21" @if(old('birthday_day')=='21') selected @endif>2 1</option>
							<option value="22" @if(old('birthday_day')=='22') selected @endif>2 2</option>
							<option value="23" @if(old('birthday_day')=='23') selected @endif>2 3</option>
							<option value="24" @if(old('birthday_day')=='24') selected @endif>2 4</option>
							<option value="25" @if(old('birthday_day')=='25') selected @endif>2 5</option>
							<option value="26" @if(old('birthday_day')=='26') selected @endif>2 6</option>
							<option value="27" @if(old('birthday_day')=='27') selected @endif>2 7</option>
							<option value="28" @if(old('birthday_day')=='28') selected @endif>2 8</option>
							<option value="29" @if(old('birthday_day')=='29') selected @endif>2 9</option>
							<option value="30" @if(old('birthday_day')=='30') selected @endif>3 0</option>
							<option value="31" @if(old('birthday_day')=='31') selected @endif>3 1</option>
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
							<label class="mark-require" for="credit_num">クレジットカード番号</label>
								<input type="text" name="credit_num" class="form-control" required="required" minlength="14" maxlength="16" id="credit-num"  pattern="^[0-9]+$" value="{{ old('credit_num')}}">
						</div>
					</div>
				<div class="form-group col-xs-12">
					<div class="input text required">
						<label class="mark-require" for="credit_name">クレジットカード名義(半角英数字)</label>
							<input type="text" name="credit_name" placeholder="例)TARO YAMADA"  class="form-control" required="required" maxlength="100" id="credit-name" pattern="^[0-9A-Za-z| ]+$" value="{{ old('credit_name')}}">
					</div>
				</div>
				<div class="form-group col-xs-12">
					<div class="required mark-require">
						<label for="expiration-date">クレジットカード有効期限</label>
						</div>
					<div class="col-xs-10 col-sm-2">
							<select name="expiration_date_month" id="expiration_date_month" class="form-control">
								<option value="" selected="selected">未選択</option>
								<option value="01" @if(old('expiration_date_month')=='01') selected @endif>01</option>
								<option value="02" @if(old('expiration_date_month')=='02') selected @endif>02</option>
								<option value="03" @if(old('expiration_date_month')=='03') selected @endif>03</option>
								<option value="04" @if(old('expiration_date_month')=='04') selected @endif>04</option>
								<option value="05" @if(old('expiration_date_month')=='05') selected @endif>05</option>
								<option value="06" @if(old('expiration_date_month')=='06') selected @endif>06</option>
								<option value="07" @if(old('expiration_date_month')=='07') selected @endif>07</option>
								<option value="08" @if(old('expiration_date_month')=='08') selected @endif>08</option>
								<option value="09" @if(old('expiration_date_month')=='09') selected @endif>09</option>
								<option value="10" @if(old('expiration_date_month')=='10') selected @endif>10</option>
								<option value="11" @if(old('expiration_date_month')=='11') selected @endif>11</option>
								<option value="12" @if(old('expiration_date_month')=='12') selected @endif>12</option>
							</select>
						</div>
					<div class="col-xs-1 padding-none form-lavel-position">
						月
					</div>
					<div class="col-xs-10 col-sm-2">
					   <select name="expiration_date_year" id="expiration_date_year" class="form-control">
							<option value="" selected="selected">未選択</option>
							<option value="28" @if(old('expiration_date_year')=='28') selected @endif>28</option>
							<option value="27" @if(old('expiration_date_year')=='27') selected @endif>27</option>
							<option value="26" @if(old('expiration_date_year')=='26') selected @endif>26</option>
							<option value="25" @if(old('expiration_date_year')=='25') selected @endif>25</option>
							<option value="24" @if(old('expiration_date_year')=='24') selected @endif>24</option>
							<option value="23" @if(old('expiration_date_year')=='23') selected @endif>23</option>
							<option value="22" @if(old('expiration_date_year')=='22') selected @endif>22</option>
							<option value="21" @if(old('expiration_date_year')=='21') selected @endif>21</option>
							<option value="20" @if(old('expiration_date_year')=='20') selected @endif>20</option>
							<option value="19" @if(old('expiration_date_year')=='19') selected @endif>19</option>
							<option value="18" @if(old('expiration_date_year')=='18') selected @endif>18</option>
						</select>
					</div>
					<div class="col-xs-1 padding-none form-lavel-position">
						年
					</div>
				</div>
				<div class="form-group col-xs-6 col-xs-offset-3" style="overflow:hidden;">
					<button class="btn btn-design" type="submit">登録する</button> 
				</div>
			</form>
		</div>
		</div>
		<div style="text-align:right;">
						<a href="https://jpack.info">トップへ戻る</a>
		</div>
	</div>
