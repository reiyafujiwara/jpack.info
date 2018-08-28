<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntryRequest;
use App\Http\Services\EntryService;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Forrest;


class EntryController extends Controller
{
    public function __construct(EntryService $entry_service)
    {
        $this->entryService = $entry_service;
    }

    public function create ()
    {
        $OrderID = date('Ymd').str_random(8);
        $Amount  = 2300;
        $Tax     = 0.08;
        return view('entryform.entryform',compact('OrderID','Amount','Tax'));
    }

    /**
     *
     * カードの有効性チェック
     * @param  Request $request [description]
     * @return [type]           [description]
     */


     /**
      * リクエストフォームをEntryRequestでバリデーションチェック
      * バリデーションチェックに引っかかった場合は入力を保持してエラー表示
      * バリデーションを通過したら入力内容確認画面へ遷移
      *
      */

     
    // public function input_check(Request $request){
    //     $data = $request->all();
    //     return view('entryform.confirm')->with($data);
    //     }
    
    
    public function confirm(Request $request){

        // if(isset($errors)){
            $this->validate($request,[
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
            ],[
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
            ],[
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
            ]);
            $params = $request->all();
            // 有効性チェックは無し、カード情報登録を行うときにも走るため、短時間で複数チェックを走らせるとカード会社に不正アクセスとみなされる可能性が高い
            // gmo取引登録
            $entryParam = $this->entryService->generateEntryParam($params);
            $res = $this->entryService->gmoEntry($entryParam);
            if(!isset($res['ErrCode'])){
            // gmo決済（有効性チェック)
            $res['OrderID'] = $entryParam['OrderID'];
            // チェック実行パラメータ作成
            $execParam = $this->entryService->generateExecParam($params, $res);
            $resp = $this->entryService->gmoExec($execParam);
            
        }
        return view('entryform.confirm')->with($params);
    }


    /**
      * 確認画面で登録を押されたら登録実行。
      * 戻るボタンを押した場合は入力内容を保持して入力画面へ戻る。
      * 
      *
      */
    


    public function store (Request $request){
    // 確認画面で戻るボタンが押された場合
    if ($request->get('action') === '入力画面に戻る') {
        // 入力画面へ戻る
        return redirect()
            ->route('entryform.entryform')
            ->withInput($request->except(['action', 'Jボックス']));
        }


        $EntryData = $request->all();

        $SfParam = $this->entryService->generateSfParams($EntryData);
        $SfAccount = $this->entryService->createSfAccount($SfParam['account']);
        // dd($SfAccount);
        $OwnService_param = $SfParam['OwnService'];
        $OwnService_Account = $this->entryService->createSfOwnService($OwnService_param);

        $member_param = $this->entryService->generateSaveMemberParam($EntryData);

        $member_id = $this->entryService->gmoSaveMember($member_param);

        if($member_id !== false){
            $save_param     = $this->entryService->generateSaveCardParam($member_id,$EntryData);

            $card_save      = $this->entryService->gmoSaveCard($save_param);
            // dd($card_save);



        // dd($member_param);


            return view('entryform.thanks');
        }
    }



        // // SF：顧客作成
        // // account contract payment delivery
        // $params = $this->entryService->generateSfParams($request->all());
        // // dd($params); 処理確認OK
        // $account        = $this->entryService->createSfAccount($params['account']);
        // // dd($account); //0015D00000NFweSQAT
        
        // // SF：取引先から取引先責任者のIDの取得
        // $contact_id     = $this->entryService->getSfContactId($account['id'], $params);
        // // dd($contact_id);
        // // GMO：会員登録用パラメータ作成
        // // dd($params);
        // $member_param   = ($params['payment']['CreditOwnerName__c']);
        // // dd($member_param); generateSaveMemberParamのMemberIDとMemberNameを直接指定で値格納確認

        // // GMO：会員登録
        // $member_id      = $this->entryService->gmoSaveMember($member_param);

        // if($member_id !== false){
        //     // GMO：会員にカード番号
        //     $save_param     = $this->entryService->generateSaveCardParam($member_id,$params['payment']);
        //     // dd($save_param);
        //     $card_save      = $this->entryService->gmoSaveCard($save_param);
        //     // dd($card_save);
        //     if(!isset($card_save['ErrCode'])){
        //         $pay = [
        //           'CardSeq__c'        => $card_save['CardSeq'],
        //           'GmoId__c'          => $member_id,
        //           'PaymentType__c'    => 'クレジットカード',
        //           'Contact__c'        => $contact_id
        //         ];

        //         // カードをGMOへ登録し、登録IDを取得

        //         $this->entryService->createSfPayment($pay);
        //         $params['contract']['Contact__c'] = $contact_id;

        //         // ↓contactのことになります
        //         // $params['delivery']['Delivery__c'] = $contact_id;
        //         $sfparams = $this->entryService->createSfContract($params['contract']);


        //          return view('entryform.thanks');
        //         }
        //     }

}



