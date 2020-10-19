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
        if($request->name && $request->email && $request->content  && $request->input('form')){
            $params = [
                'name' => $request->name,
                'email' => $request->email,
                'content' => $request->content,
                'form' => $_POST['form'],
            ];
            $address = 'kazuma020408@icloud.com';
            $subject = $params['form'].'について問い合わせがありました。';
            $content = '内容:<br>' . $params['content'];
            $headers = <<<EOF
            From : {$params['email']}
            Return-Path: nanitabe@co.jp
            Content-type: text/plain;charset=ISO-2022-JP
            EOF;
            $is_success = mb_send_mail($address,$subject,$content,$headers);
            if(!$is_success){
                die('メール送信失敗');
                $mailErrorMessage = 'メール送信失敗に失敗しました。';
                return view('inquery')->with('succsesMessage',$mailErrorMessage);
            }
            DB::beginTransaction();
            try {
                DB::insert('insert into inquerys (name, email, content, form) values (:name, :email, :content, :form)',$params);
                DB::commit();
                $succsesMessage = 'お問い合わせありがとうございます';
                return view('inquery')->with('succsesMessage',$succsesMessage);
            } catch(\Exception $e){
                DB::rollBack();
                $dbErrorMessage = 'DB接続に失敗しました';
                return view('inquery')->with('dbErrorMessage',$dbErrorMessage);
            }
        } else {
            $emptyMessage = '未入力があります';
            return view('inquery')->with('emptyMessage',$emptyMessage);
        }

    }
}
