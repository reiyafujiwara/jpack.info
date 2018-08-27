<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Forrest;
use Excepsion;
use App\Mail\SendingEntry;
use Mail;
use Carbon\Carbon;


class GMOEntryService 
{
     public function generateEntryParam() {

        $OrderID = date('Ymd').str_random(8);
        $Amount  = 2300;
        $Tax     = 0.08;

        // 取引登録をする
        // パラメータ生成
        $param =[
            'ShopID'    => env('SHOP_ID'),
            'ShopPass'  => env('SHOP_PASS'),
            'OrderID'   => $OrderID, //日付（yyyymmdd）+ランダム英数字8桁のIDを付与
            'JobCd'     => 'CHECK', //有効性チェック
            'Amount'    => $Amount,
            'Tax'       => $Amount * $Tax
        ];
        return $param;
    }

    public function generateExecParam(array $data,  $param) {

        // 決済実行
        // 
        $execParam = [
            'AccessID'      => $param['AccessID'],
            'AccessPass'    => $param['AccessPass'],
            'CardNo'        => $data['credit_num'],
            'Expire'        => $data['expiration_date_month'].$data['expiration_date_year'],
            'OrderID'       => $param['OrderID']
        ];
        //dd($execParam['OrderID']);
        return $execParam;

    }

    public function generateSaveMemberParam($contact_id,$data) {
        // dd($contact_id,$name);
        $execParam = [
            'SiteID'    => env('SITE_ID'),
            'SitePass'  => env('SITE_PASS'),
            'MemberID'  => $contact_id,
            'MemberName'  => $data
        ];
        return $execParam;
    }
     
    public function generateSaveCardParam($member_id,$params) {

        $execParam = [
            'SiteID'        => env('SITE_ID'),
            'SitePass'      => env('SITE_PASS'),
            'MemberID'      => $member_id,
            'DefaultFlag'    => 1,
            'CardNo'        => $data['credit_num'],
            'Expire'        => $data['expiration_date_month'].$data['expiration_date_year'],
            'HolderName'    => $data['credit_name'],
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
        // dd($param);
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