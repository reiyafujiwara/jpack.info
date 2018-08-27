<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Forrest;
use Excepsion;
use App\Mail\SendingEntry;
use Mail;
use Carbon\Carbon;


class SFEntryService 
{
        public function generateSfParams(array $body){
        $account = $ownServices = [];
        /*
         * 取引先(顧客情報),自社サービス登録内容
         */

         $account = [
            "LastName"          => $body['name1'],
            "FirstName"         => $body['name2'],
            "Furigana__c"       => $body['kana1'].' '.$body['kana2'],
            "LastnameKana__c"   => $body['kana1'],
            "FirstnameKana__c"  => $body['kana2'],
            "Phone1__c"         => $body['tel'],
            "PostalCode_del__c" => $body['zipcode1'].$body['zipcode2'],
            "Address__c"        => $body['address1'].$body['address2'].$body['address3'],
            "PersonBirthdate"   => $body['birthday_year'].'-'.$body['birthday_month'].'-'.$body['birthday_day'],
            "Sex__c"            => $body['sex'],
            "PriorityContact__c"=> '電話①' 
         ];

         $OwnService = [
             'EntryDay__c' => date('Ymd'),
             //どこから指定して入力？
             'OrderID__c' => ''
         ];

         $payment = [
            "CreditCardNumber__c"   => $body["credit_num"],
            "CreditLimitMonth__c"   => $body["expiration_date_month"],
            "CreditLimitYear__c"    => $body["expiration_date_year"],
            "CreditOwnerName__c"    => $body["credit_name"],
        ];

        return compact('account','ownServices','payment');

        }

    /*
     * @description
     * @return account_id
     */
    public function createSfAccount($body){
        Forrest::authenticate();
        $a = Forrest::query("SELECT Id FROM Account WHERE LastName='".$body['LastName']."'AND Phone1__c='".$body['Phone1__c']."'");

        if($a['totalSize'] === 0){
            $a = Forrest::sobjects('Account',[
              'method' => 'post',
              'body'   => $body
            ]);
            return $a;
        }
        return ['id' => $a['records'][0]['Id']];
    }

    public function getSfContactId($account_id){
        Forrest::authenticate();

        $c = Forrest::query("select Id from Contact where AccountId='".$account_id."'");
        // dd($c);
        // 取引先責任者ID取得
        $contact_id = $c['records'][0]['Id'];
        // dd($contact_id);

        return $contact_id;

    }

    public function createSfOwnservice($param){
        Forrest::authenticate();

        $c = Forrest::sobjects('OwnService__c',[
                'method' => 'post',
                'body'   => $Ownservice
        ]);
        // 取引先責任者ID取得
        return $c;
    }

    public function createSfContract($param){
        Forrest::authenticate();

        $c = Forrest::sobjects('SimContract__c',[
                'method' => 'post',
                'body'   => $param
        ]);
        // 取引先責任者ID取得
        return $c;
    }



    /**
     * sfのcontract情報を取得
     * @param  [type] $sfparams [description]
     * @return [type]           [description]
     */
    public function getSfContract($sfparams){
        Forrest::authenticate();

        // 絞り込みがわからなかったので一旦全件取得
        $c = Forrest::query("SELECT Id, Name FROM SimContract__c WHERE Id='".$sfparams['id']."'");

        // 取引先責任者ID取得
        return $c['records'][0];
    }

    // public function sendMail($params, $sfcontract, $plan)
    // {
    //     // メールの送信先、送信元情報
    //     $options = [
    //         'from' => env('MAIL_FROM_ADDRESS'),
    //         'from_jp' => env('MAIL_FROM_NAME'),
    //         'to' => $params['account']['PersonEmail'],
    //     ];

    //     // メールの送信内容
    //     $data = [
    //         // 契約ID
    //         'sfid' => $sfcontract['Name'],
    //         // セット内容
    //         'set' => $plan->set,
    //         // プラン
    //         'plan' => $plan->name,
    //         // 月額
    //         'price' => $plan->price,
    //         // 25ヶ月目以降料金
    //         'priceafter' => $plan->priceafter,
    //         // 最低利用期間
    //         'minimumperiod' => $plan->minimumperiod,
    //         // 契約者名
    //         'name' => $params['account']['LastName'].' '.$params['account']['FirstName'],
    //         // 届け先住所
    //         'address' => $params['delivery']['SameAddress__c'] ? $params['account']['Address__c'] : $params['delivery']['PreferredAddress__c'],
    //         // お届け希望日時
    //         'preferreddatetime' => (isset($params['delivery']['PreferredDate__c']) ? Carbon::parse($params['delivery']['PreferredDate__c'])->format('Y年m月d日') : '日付指定なし').' '.(isset($params['delivery']['PreferredTime__c']) ? $params['delivery']['PreferredTime__c'] : '時間指定なし'),
    //     ];
    //     Mail::to($options['to'])->bcc(env('MAIL_FORWARD_ADDRESS'))->send(new SendingEntry($options, $data));
    // }


}
