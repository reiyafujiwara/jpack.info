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

    public function generateEntryParam($params){

        // 取引登録をする
        // パラメータ生成
        $param =[
            'ShopID'    => env('SHOP_ID'),
            'ShopPass'  => env('SHOP_PASS'),
            'OrderID'   => $params['OrderID'], //日付（yyyymmdd）+ランダム英数字8桁のIDを付与
            'JobCd'     => 'CHECK', //有効性チェック
            'Amount'    => $params['Amount'],
            'Tax'       => $params['Amount'] * $params['Tax']
        ];
        // dd($param);
        return $param;
    }

    public function generateExecParam(array $data,$param) {
        // dd($data,$param);
        // 決済実行
        // 
        $execParam = [
            'AccessID'      => $param['AccessID'],
            'AccessPass'    => $param['AccessPass'],
            'CardNo'        => $data['credit_num'],
            'Expire'        => $data['expiration_date_month'].$data['expiration_date_year'],
            'OrderID'       => $param['OrderID']
        ];
        return $execParam;

    }

    public function generateSaveMemberParam($EntryData) {
        // dd($EntryData);
        $execParam = [
            'SiteID'    => env('SITE_ID'),
            'SitePass'  => env('SITE_PASS'),
            'MemberID'  => uniqid("JBOX_"),
            'MemberName'  => $EntryData['name1'].$EntryData['name2']
        ];

        return $execParam;
    }
     
    public function generateSaveCardParam($member_id,$EntryData) {

        $execParam = [
            'SiteID'        => env('SITE_ID'),
            'SitePass'      => env('SITE_PASS'),
            'MemberID'      => $member_id,
            'DefaultFlag'    => 1,
            'CardNo'        => $EntryData['credit_num'],
            'Expire'        => $EntryData['expiration_date_month'].$EntryData['expiration_date_year'],
            'HolderName'    => $EntryData['credit_name']
        ];
        // dd($execParam);
        return $execParam;
    }

    /*
     * @description GMOへrequestを投げる
     *
     */
    public function gmoEntry(array $param){
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
// dd($param);
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

    public function generateSfParams(array $EntryData){
        // dd($EntryData);
        /*
         * 取引先(顧客情報),自社サービス登録内容
         */

         $account = [
            "LastName"          => $EntryData['name1'],
            "FirstName"         => $EntryData['name2'],
            "Furigana__c"       => $EntryData['kana1'].' '.$EntryData['kana2'],
            "LastnameKana__c"   => $EntryData['kana1'],
            "FirstnameKana__c"  => $EntryData['kana2'],
            "Phone1__c"         => $EntryData['tel'],
            "PostalCode_del__c" => $EntryData['zipcode1'].$EntryData['zipcode2'],
            "Address__c"        => $EntryData['address1'].$EntryData['address2'].$EntryData['address3'],
            "PersonBirthdate"   => $EntryData['birthday_year'].'-'.$EntryData['birthday_month'].'-'.$EntryData['birthday_day'],
            "Sex__c"            => $EntryData['sex'],
            "PriorityContact__c"=> '電話①' 
         ];

         $OwnService = [
             
             'EntryDay__c' => date('Y').'-'.date('m').'-'.date('d'),
             //どこから指定して入力？
             'Name' => $EntryData['OrderID'],
             'GMO_ID__C' => uniqid("JBOX_")

         ];



        return compact('account','OwnService','payment');

        }


    /*
     * @description
     * @return account_id
     */
    public function createSfAccount($SfEntryData){
        // dd($SfEntryData);
        Forrest::authenticate();
        $a = Forrest::query("SELECT Id FROM Account WHERE LastName='".$SfEntryData['LastName']."'AND Phone1__c='".$SfEntryData['Phone1__c']."'");
        if($a['totalSize'] === 0){
            $a = Forrest::sobjects('Account',[
              'method' => 'post',
              'body'   => $SfEntryData
            ]);
            return $a;
        }
        return ['id' => $a['records'][0]['Id']];
    }

    // public function getSfContactId($account_id){
    //     Forrest::authenticate();

    //     $c = Forrest::query("select Id from Contact where AccountId='".$account_id."'");
    //     // 取引先責任者ID取得
    //     $contact_id = $c['records'][0]['Id'];
    //     return $contact_id;

    // }
    
    public function createSfOwnservice($OwnService_param){
        Forrest::authenticate();

        $c = Forrest::sobjects('OwnService__c',[
                'method' => 'post',
                'body'   => $OwnService_param
        ]);
        // 取引先責任者ID取得
        return $c;
    }


    public function sendMail($params, $sfcontract, $plan)
    {
        // メールの送信先、送信元情報
        $options = [
            'from' => env('MAIL_FROM_ADDRESS'),
            'from_jp' => env('MAIL_FROM_NAME'),
            'to' => $params['account']['PersonEmail'],
        ];

        // メールの送信内容
        $data = [
            // 契約ID
            'sfid' => $sfcontract['Name'],
            // セット内容
            'set' => $plan->set,
            // プラン
            'plan' => $plan->name,
            // 月額
            'price' => $plan->price,
            // 25ヶ月目以降料金
            'priceafter' => $plan->priceafter,
            // 最低利用期間
            'minimumperiod' => $plan->minimumperiod,
            // 契約者名
            'name' => $params['account']['LastName'].' '.$params['account']['FirstName'],
            // 届け先住所
            'address' => $params['delivery']['SameAddress__c'] ? $params['account']['Address__c'] : $params['delivery']['PreferredAddress__c'],
            // お届け希望日時
            'preferreddatetime' => (isset($params['delivery']['PreferredDate__c']) ? Carbon::parse($params['delivery']['PreferredDate__c'])->format('Y年m月d日') : '日付指定なし').' '.(isset($params['delivery']['PreferredTime__c']) ? $params['delivery']['PreferredTime__c'] : '時間指定なし'),
        ];
        Mail::to($options['to'])->bcc(env('MAIL_FORWARD_ADDRESS'))->send(new SendingEntry($options, $data));
    }


}
