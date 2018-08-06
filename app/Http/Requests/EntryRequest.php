<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name1' => 'required|regex:/^[ぁ-んァ-ン一-龥]/',
            'name2' => 'required|regex:/^[ぁ-んァ-ン一-龥]/',
            'kana1' => 'required|regex:/^[ァ-ヶー]+$/u',
            'kana2' => 'required|regex:/^[ァ-ヶー]+$/u',
            'sex' => 'required',
            'tel' => 'required|regex:/^\d{11}$/',
            'zipcode1' => 'required|regex:/^\d{3}$/',
            'zipcode2' => 'required|regex:/^\d{4}$/',
            'address1' => 'required',
            'address2' => 'required',
            'address3' => '',
            'birthday_year' => 'required',
            'birthday_month' => 'required',
            'birthday_day' => 'required',
            'credit_num' => 'required|digits_between:15,16',
            'credit_name' => 'required|regex:/^[A-Z]+$/',
            'expiration_date_month' => 'required',
            'expiration_date_year' => 'required'
        ];
    }

    public function attributes() {
        return [
            'name1' => '性',
            'name2' => '名',
            'kana1' => 'セイ',
            'kana2' => 'メイ',
            'sex' => '性別',
            'tel' => '電話番号',
            'zipcode1' => '郵便番号(左)',
            'zipcode2' => '郵便番号(右)',
            'address1' => '住所(市・区・郡及び町村名)',
            'address2' => '住所（丁目・番地）',
            'address3' => '住所(建物名・部屋番号)',
            'birthday_year' => '生年月日(年)',
            'birthday_month' => '生年月日(月)',
            'birthday_day' => '生年月日(日)',
            'credit_num' => 'クレジットカード番号',
            'credit_name' => 'クレジットカード名義',
            'expiration_date_month' => 'クレジットカード有効期限(月)',
            'expiration_date_year' => 'クレジットカード有効期限(年)'
        ];
    }


    public function messages()
    {
      return [
        'name1.required' => '性を入力して下さい。',
        'name1.regex' => '性は全角で正しく入力して下さい。',   
        'name2.required' => '名を入力して下さい。',
        'name2.regex' => '名は全角で正しく入力して下さい。',
        'kana1.required' => 'セイを入力して下さい。',
        'kana1.regex' => 'セイは全角カタカナで入力して下さい。',
        'kana2.required' => 'メイを入力して下さい。',
        'kana2.regex' => 'メイは全角カタカナで入力して下さい。',
        'sex.required' => '性別を選択して下さい。',
        'tel.required' => '電話番号を入力して下さい。',
        'tel.regex' => '電話番号を正しく入力して下さい。',
        'zipcode1.required' => '郵便番号(左)を入力して下さい。',
        'zipcode1.regex' => '郵便番号左枠は半角の3桁で入力して下さい。',
        'zipcode2.required' => '郵便番号(右)を入力して下さい。',
        'zipcode2.regex' => '郵便番号右枠は半角の4桁で入力して下さい。',
        'address1.required' => '住所(市・区・郡及び町村名)を入力して下さい。',
        'address2.required' => '住所（丁目・番地）を入力して下さい。',
        'birthday_year.required' => '生年月日(年)を入力して下さい。',
        'birthday_month.required' => '生年月日(月)を入力して下さい。',
        'birthday_day.required' => '生年月日(日)を入力して下さい。',
        'credit_num.required' => 'クレジットカード番号を入力して下さい。',
        'credit_num.digits_between' => 'クレジットカード番号の桁数は正しく入力して下さい。',
        'credit_name.required' => 'クレジットカード名義を入力して下さい。',
        'credit_name.regex' => 'クレジットカード名義は半角英数字で入力して下さい。',
        'expiration_date_month.required' => 'クレジットカード有効期限(月)を入力して下さい。',
        'expiration_date_year.required' => 'クレジットカード有効期限(年)を入力して下さい。'
      ];
    }
}
