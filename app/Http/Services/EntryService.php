<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Forrest;
use Excepsion;
use App\Mail\SendingEntry;
use Mail;
use Carbon\Carbon;


class EntryService 
{

    public function generateEntryParam() {

        // 取引登録をする
        // パラメータ生成
        $param =[
            'ShopID'    => env('SHOP_ID'),
            'ShopPass'  => env('SHOP_PASS'),
            'OrderID'   => date('Ymd').str_random(8),//日付（yyyymmdd）+ランダム英数字8桁のIDを付与
            'JobCd'     => 'CHECK' //有効性チェック

        ];

        return $param;
    }
    public function generateExecParam(array $data,  $param) {
        $execParam = [
            'AccessID'      => $param['AccessID'],
            'AccessPass'    => $param['AccessPass'],
            'CardNo'        => $data['credit_num'],
            'Expire'        => $data['expiration_date_month'].$data['expiration_date_year'],
            'OrderID'       => $param['OrderID']
        ];
        return $execParam;

    }
    public function generateSaveMemberParam($data,$name) {
        // dd($contact_id,$params );
        $execParam = [
            'SiteID'    => env('SITE_ID'),
            'SitePass'  => env('SITE_PASS'),
            'MemberID'  => $data['OredrID'],
            'MemberName'  => $name
        ];
        dd($execParam);
        return $execParam;
    }
    public function generateSaveCardParam($member_id,$params) {
        // dd($contact_id,$params );
        $execParam = [
            'SiteID'        => env('SITE_ID'),
            'SitePass'      => env('SITE_PASS'),
            'MemberID'      => $member_id,
            'DefaultFlag'    => 1,
            'CardNo'        => $data['credit_num'],
            'Expire'        => $data['expiration_date_month'].$data['expiration_date_year'],
            'HolderName'    => $data['credit_name'],
        ];
        return $execParam;
    }

    /*
     * @description GMOへrequestを投げる
     *
     */
    public function gmoEntry(array $param){
        //$url = env('GMO_URL').'/payment/EntryTran.idPass';
        $url = env('GMO_URL').'/payment/EntryTran.idPass';
        $client = new Client();
        // guzzleの送信処理 データは'form_params'というキー名(guzzleの仕様)
        $res = $client->request('post', $url, [
            'form_params' => $param
        ]);
        parse_str($res->getBody(),$param);

        return $param;
    }


    public function gmoExec(array $param){
        $url = env('GMO_URL').'/payment/ExecTran.idPass';
        $client = new Client();
        // guzzleの送信処理 データは'form_params'というキー名(guzzleの仕様)
        $res = $client->request('post', $url, [
            'form_params' => $param
        ]);
        parse_str($res->getBody(),$param);
        return $param;
    }

    public function gmoSaveMember(array $param){
        $url = env('GMO_URL').'/payment/SaveMember.idPass';
        $client = new Client();
        // guzzleの送信処理 データは'form_params'というキー名(guzzleの仕様)
        // dd($param);
        $res = $client->request('post', $url, [
            'form_params' => $param
        ]);
        parse_str($res->getBody(),$param['err']);

        if (isset($param['err']['ErrCode']) && $param['err']['ErrInfo'] !== 'E01390010') {
            // 取引登録失敗
            // throw new \Exception('gmoSaveMember');
            return false;
        }

        return $param['MemberID'];
    }

    public function gmoSaveCard($param){
        $url = env('GMO_URL').'/payment/SaveCard.idPass';
        $client = new Client();
        // guzzleの送信処理 データは'form_params'というキー名(guzzleの仕様)
        $res = $client->request('post', $url, [
            'form_params' => $param
        ]);
        parse_str($res->getBody(),$param);

        return $param;
    }

    public function generateSfParams(array $params){
        // initialize
        $account = $ownServices = [];
        /*
         * 取引先、契約、決済方法、配送
         */
        $account = [
            //"LastName"          => $body["LastName"],
            "LastName"          => $params['name1'],
            "FirstName"         => $params['name2'],
            "Furigana__c"       => $params['kana1'].' '.$params['kana2'],
            "LastnameKana__c"   => $params['kana1'],
            "FirstnameKana__c"  => $params['kana2'],
            "Phone1__c"         => $params['tel'],
            // "Phone2__c"         => $Phone2__c"], 電話番号一つしか打ち込まないため
            "PostalCode_del__c" => $params['zipcode1'].$params['zipcode2'],
            "Address__c"        => $params['address1'].$params['address2'].$params['address3'],
            "PersonBirthdate"   => $params['birthday_year'].$params['birthday_month'].$params['birthday_day'],
            "Sex__c"            => $params['sex'],
            "PriorityContact__c"=> '電話①' 
            // メールが入らない~.
            //"PersonEmail"       => $body["PersonEmail"]
        ];

        $ownServices = [
            
        ];




    //     // $contract = [
    //     //     "Plan__c"               => $body['Plan__c'],
    //     //     "Status__c"             => "配送待ち",
    //     //     "ContractClass__c"      => '個人',
    //     //     "Norm__c"               => $body['Norm__c'],
    //     // ];
    //     // // 安心サービスが定義されており、かつ値がtrueの時
    //     // if($body['SafeRegistration__c'] ){
    //     //     $contract['SafeRegistration__c'] = $body['SafeRegistration__c'];
    //     // }

        $payment = [
            "CreditCardNumber__c"   => $params["credit_num"],
            "CreditLimitMonth__c"   => $params["expiration_date_month"],
            "CreditLimitYear__c"    => $params["expiration_date_year"],
            "CreditOwnerName__c"    => $params["credit_name"],
        ];
        return compact('account','ownServices','payment');

        }



    //     return compact('account','contract','payment','delivery');

    // }
    /*
     * @description
     * @return account_id
     */
    // public function createSfAccount($params){
    //     Forrest::authenticate();
    //     $a = Forrest::query("SELECT Id FROM Account WHERE LastName='".$params["name1"]."'AND Phone1__c='".$params["tel"]."'");
    //     //dd($a); 結果　totalsize=>0 done =>true records =>[]
    //     if($a['totalSize'] === 0){
    //         $a = Forrest::sobjects('Account',[
    //           'method' => 'post',
    //           'params'   => $params
    //         ]);
    //         return $a;
    //     }
    //     return ['id' => $a['records'][0]['Id']];
    // }

    // public function getSfContactId($account_id){
    //     Forrest::authenticate();

    //     $c = Forrest::query("select Id from Contact where AccountId='".$account_id."'");
    //     // 取引先責任者ID取得
    //     $contact_id = $c['records'][0]['Id'];
    //     return $contact_id;

    // }

    // public function createSfPayment($param){
    //     Forrest::authenticate();

    //     $c = Forrest::sobjects('SimPaymentInfo__c',[
    //             'method' => 'post',
    //             'body'   => $param
    //     ]);
    //     // 取引先責任者ID取得
    //     return $c;
    // }

    // public function createSfContract($param){
    //     Forrest::authenticate();

    //     $c = Forrest::sobjects('SimContract__c',[
    //             'method' => 'post',
    //             'body'   => $param
    //     ]);
    //     // 取引先責任者ID取得
    //     return $c;
    // }

    // public function createSfDelivery($param){
    //     Forrest::authenticate();

    //     $c = Forrest::sobjects('Delivery__c',[
    //             'method' => 'post',
    //             'body'   => $param
    //     ]);
    //     // 取引先責任者ID取得
    //     return $c;
    // }

    // /**
    //  * sfのcontract情報を取得
    //  * @param  [type] $sfparams [description]
    //  * @return [type]           [description]
    //  */
    // public function getSfContract($sfparams){
    //     Forrest::authenticate();

    //     // 絞り込みがわからなかったので一旦全件取得
    //     $c = Forrest::query("SELECT Id, Name FROM SimContract__c WHERE Id='".$sfparams['id']."'");

    //     // 取引先責任者ID取得
    //     return $c['records'][0];
    // }

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
