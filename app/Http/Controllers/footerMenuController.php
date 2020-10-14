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
