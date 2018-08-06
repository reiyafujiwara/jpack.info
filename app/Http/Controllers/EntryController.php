<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntryRequest;
use App\Http\Services\EntryService;
use GuzzleHttp\Client;
use Carbon\Carbon;

class EntryController extends Controller
{
    public function __construct(EntryService $entry_service)
    {
        $this->entryService = $entry_service;
    }

    public function create ()
    {
        return view('entryform.entryform');
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

     
    public function confirｍ(EntryRequest $request){
        $data = $request->all();

        // gmo取引登録
        $entryParam = $this->entryService->generateEntryParam($data);
        //ddを実行してもentryparamの値が表示されない（通常通りの画面遷移をしてしまう）
        $res = $this->entryService->gmoEntry($entryParam);
        //ddを実行してもentryparamの値が表示されない（通常通りの画面遷移をしてしまう）
        if(!isset($res['ErrCode'])){
          // gmo決済（有効性チェック)
          $res['OrderID'] = $entryParam['OrderID'];
          // チェック実行パラメータ作成
          $execParam = $this->entryService->generateExecParam($params, $res);
          $resp = $this->entryService->gmoExec($execParam);
          dd($resp);

        if(!isset($resp['ErrCode'])){
    
            return view('entryform.confirm')->with($data);
            }

            // エラーがあったので確認画面へ進まずに戻る
        return view('entryform.entryform');
        }
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
        return view('entryform.thanks');
        }
            
    }


 
