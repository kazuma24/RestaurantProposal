<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class footerMenuController extends Controller
{
    // ガイダンスページ
    public function guidance(){
        return view('guidance');
    }
    //利用規約
    public function rule(){
        return view('rule');
    }
    //問合せフォーム
    public function inquery(){
        return view('inquery');
    }
    //問合せ処理
    public function inqueryPost(Request $request){
        if($request->name && $request->email && $request->content){
            $params = [
                'name' => $request->name,
                'email' => $request->email,
                'content' => $request->content
            ];
            $address = 'kazuma020408@icloud.com';
            $subject = '問い合わせがありました。';
            $content = '確認しよ';
            $headers = <<<EOF
            From : nanitabe@co.jp
            Return-Path: nanitabe@co.jp
            Content-type: text/plain;charset=ISO-2022-JP
            EOF;
            $is_success = mb_send_mail($address,$subject,$content,$headers);
            if(!$is_success){
                die('メール送信失敗');
            }
            DB::beginTransaction();
            try {
                DB::insert('insert into inquerys (name, email, content) values (:name, :email, :content)',$params);
                DB::commit();
                $succsesMessage = 'お問い合わせありがとうございます';
                return view('inquery')->with('succsesMessage',$succsesMessage);
            } catch(\Exception $e){
                DB::rollBack();
                $dbErrorMessage = '接続に失敗しました';
                return view('inquery')->with('dbErrorMessage',$dbErrorMessage);
            }
        } else {
            $emptyMessage = '未入力があります';
            return view('inquery')->with('emptyMessage',$emptyMessage);
        }

    }
}
