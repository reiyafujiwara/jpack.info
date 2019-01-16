<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Forrest;
use Excepsion;
use App\Mail\EntryMail;
use Mail;
use Carbon\Carbon;


class EntryService 
{

    // public function generateEntryParam($params){

    //     // 取引登録をする
    //     // パラメータ生成
    //     $param =[
    //         'ShopID'    => env('SHOP_ID'),
    //         'ShopPass'  => env('SHOP_PASS'),
    //         'OrderID'   => $params['OrderID'], //日付（yyyymmdd）+ランダム英数字8桁のIDを付与
    //         'JobCd'     => 'CHECK', //有効性チェック
    //     ];
    //     // dd($param);
    //     return $param;
    // }

    // public function generateExecParam(array $data,$param) {
    //     // dd($data,$param);
    //     // 決済実行
    //     // 
    //     $execParam = [
    //         'AccessID'      => $param['AccessID'],
    //         'AccessPass'    => $param['AccessPass'],
    //         'CardNo'        => $data['credit_num'],
    //         'Expire'        => $data['expiration_date_year'].$data['expiration_date_month'],
    //         'OrderID'       => $param['OrderID'],
    //         // 'Token'         => $param[''],
    //         // 'TokenType'     => $param['']
    //     ];

    //     return $execParam;

    // }

    public function generateSaveMemberParam($SfParam) {
        // dd($SfParam);
        $execParam = [
            'SiteID'    => env('SITE_ID'),
            'SitePass'  => env('SITE_PASS'),
            'MemberID'  => $SfParam['OwnService']['Name'],
            'MemberName'  => $SfParam['OwnService']['Member_name__c']
        ];
        // dd($execParam);
        return $execParam;
    }
     
    public function generateSaveCardParam($member_id,$SfParam) {
        // dd($SfParam);
        $execParam = [
            'SiteID'        => env('SITE_ID'),
            'SitePass'      => env('SITE_PASS'),
            'MemberID'      => $member_id,
            'DefaultFlag'   => 1,
            // 'CardNo'        => $SfParam['payment']['CreditCardNumber'],
            // 'Expire'        => $SfParam['payment']['CreditLimit'],
            // 'HolderName'    => $SfParam['payment']['CreditOwnerName']
            'Token'         => $SfParam['payment']['credit_token']
        ];
        // dd($execParam);
        return $execParam;
    }

    /*
     * @description GMOへrequestを投げる
     *
     */
    // public function gmoEntry(array $param){
    //     $url = env('GMO_URL').'/payment/EntryTran.idPass';
    //     $client = new Client();
    //     // guzzleの送信処理 データは'form_params'というキー名(guzzleの仕様)
    //     $res = $client->request('post', $url, [
    //         'form_params' => $param
    //     ]);
    //     parse_str($res->getBody(),$param);
    //         // dd($param);
    //     return $param;
    // }


    // public function gmoExec(array $param){
    //     $url = env('GMO_URL').'/payment/ExecTran.idPass';
    //     $client = new Client();
    //     // guzzleの送信処理 データは'form_params'というキー名(guzzleの仕様)
    //     $res = $client->request('post', $url, [
    //         'form_params' => $param
    //     ]);
    //     parse_str($res->getBody(),$param);
    //     // dd($res,$param);
    //     return $param;
    // }

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
        // dd($param);
        return $param;
    }

    public function generateSfParams(array $SfParam){
        // dd($SfParam);
        /*
         * 取引先(顧客情報),自社サービス登録内容
         */

         $account = [
            "LastName"          => $SfParam['name1'],
            "FirstName"         => $SfParam['name2'],
            "Furigana__c"       => $SfParam['kana1'].' '.$SfParam['kana2'],
            "LastnameKana__c"   => $SfParam['kana1'],
            "FirstnameKana__c"  => $SfParam['kana2'],
            "Phone1__c"         => $SfParam['tel'],
            "PostalCode_del__c" => $SfParam['zipcode1'].$SfParam['zipcode2'],
            "Address__c"        => $SfParam['address1'].$SfParam['address2'].$SfParam['address3'],
            "PersonBirthdate"   => $SfParam['birthday_year'].'-'.$SfParam['birthday_month'].'-'.$SfParam['birthday_day'],
            "Sex__c"            => $SfParam['sex'],
            "PriorityContact__c"=> '電話①' 
         ];

         $OwnService = [
             'EntryDate__c'     => date('Y-m-d'),
             'Member_name__c'   => $SfParam['credit_name'],
             'Name'             => uniqid("JBOX"),
             'Option_name__c'   => 'Jボックス'
         ];

         
         $payment = [
            "credit_name"    => $SfParam["credit_name"],
            "credit_token"   => $SfParam["credit_token"]
        ];

        
        return compact('account','OwnService','payment');

        }

        // public function generateSfParams(array $SfParam){
        //     // dd($SfParam);
        //     /*
        //      * 取引先(顧客情報),自社サービス登録内容
        //      */
    
        //      $account = [
        //         "LastName"          => $SfParam['name1'],
        //         "FirstName"         => $SfParam['name2'],
        //         "Furigana__c"       => $SfParam['kana1'].' '.$SfParam['kana2'],
        //         "LastnameKana__c"   => $SfParam['kana1'],
        //         "FirstnameKana__c"  => $SfParam['kana2'],
        //         "Phone1__c"         => $SfParam['tel'],
        //         "PostalCode_del__c" => $SfParam['zipcode1'].$SfParam['zipcode2'],
        //         "Address__c"        => $SfParam['address1'].$SfParam['address2'].$SfParam['address3'],
        //         "PersonBirthdate"   => $SfParam['birthday_year'].'-'.$SfParam['birthday_month'].'-'.$SfParam['birthday_day'],
        //         "Sex__c"            => $SfParam['sex'],
        //         "PriorityContact__c"=> '電話①' 
        //      ];
    
        //      $OwnService = [
        //          'EntryDate__c'     => date('Y-m-d'),
        //          'Member_name__c'   => $SfParam['credit_name'],
        //          'Name'             => uniqid("JBOX"),
        //          'Option_name__c'   => 'Jボックス'
        //      ];
    
             
        //      $payment = [
        //         "CreditCardNumber"   => $SfParam["credit_num"],
        //         "CreditLimit"        => $SfParam['expiration_date_year'].$SfParam['expiration_date_month'],
        //         "CreditOwnerName"    => $SfParam["credit_name"],
        //         "credit_token"       => $SfParam["credit_token"]
        //     ];
    
    
        //     return compact('account','OwnService','payment');
    
        //     }

    /*
     * @description
     * @return account_id
     */    
    public function createSfAccount($SfParam){
        // dd($SfSfParam);
        Forrest::authenticate();
        $a = Forrest::query("SELECT Id FROM Account WHERE LastName='".$SfParam['LastName']."'AND Phone1__c='".$SfParam['Phone1__c']."'");
        // dd($a);
        if($a['totalSize'] === 0){
            $a = Forrest::sobjects('Account',[
              'method' => 'post',
              'body'   => $SfParam
            ]);
            return $a;
        }
        // dd($a); -> 0015D00000Qm6PyQAJ
        return ['id' => $a['records'][0]['Id']];
    }

    public function getSfContactId($account_id){
        // dd($account_id);
        // 0015D00000QmJDXQA3
        Forrest::authenticate();

        $c = Forrest::query("SELECT Id FROM Contact WHERE AccountId='".$account_id."'");
        // dd($c);
   
        // 取引先責任者ID取得
        $contact_id = $c['records'][0]['Id'];
        // dd($contact_id);
        
        // dd($contact_id,$account_id);
        return $contact_id;

    }


    public function createSfOwnservice($SfParam){
        // dd($SfParam['OwnService']);

        Forrest::authenticate();

        $c = Forrest::sobjects('OwnServices__c',[
                'method' => 'post',
                'body'   => $SfParam['OwnService']
        ]);
        dd($c);
        // 取引先責任者ID取得
        return $c;
    }


}
