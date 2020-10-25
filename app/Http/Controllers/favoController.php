<?php

namespace App\Http\Controllers;

use App\Favo;
use Illuminate\Http\Request;
use App\Http\Controllers\MainPageController as Main;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class favoController extends Controller
{
    //お気に入り登録
    public function favo(Request $request) {
        //本会員ユーザーか確認
        if(Auth::check()){
            //すでにお気に入しているか確認
            $count = Favo::where('user_id',Auth::id())->where('restId',$request->restId)->count();
            if($count > 0){
                $data = [
                    'flg' => 1,
                    'message' => '既にお気に入りされています'
                ];
                $res = response()->json($data);
                return $res;
            }
            //お気に入り店舗の件数確認
            $count = Favo::where('user_id',Auth::id())->count();
            logger($count);
            if($count > 39){
                $data20 = [
                    'flg' => 40,
                    'message' => 'お気に入り登録は40件までです'
                ];
                $res = response()->json($data20);
                return $res;
            }
            $responseData = Main::getRestaurantData($request->restId);
            // API実行エラーの場合
            if ($responseData == "Client error") {
                return view('errors.404');
            }
            /* 整形用のデータを作成 */
            // 飲食店情報配列
            $restaurantArray = null;
            // 画面出力用データ
            $viewData = null;
            // 配列のkeyによってデータを振り分ける
            foreach ($responseData as $responseKey => $apiData) {
                switch ($responseKey) {
                    case 'rest':
                        $restaurantArray = $apiData;
                        $viewData = json_encode($restaurantArray);
                        break;
                    default:
                        break;
                }
            }
            logger($restaurantArray);
            // クライアントの使用端末を判定
            $usedTerminal = Main::isMobileOrPc($request->header('User-Agent'));
            DB::beginTransaction();
            try {
                $favo = new \App\Favo;
                $favo->user_id = Auth::id();
                $favo->restId = $restaurantArray[0]['id'];
                $favo->restName = $restaurantArray[0]['name'];
                $favo->restImageUrl = $restaurantArray[0]['image_url']['shop_image1'];
                if($usedTerminal == 'pc'){
                    $favo->restUrl = $restaurantArray[0]['coupon_url']['pc'];
                } else {
                    $favo->restUrl = $restaurantArray[0]['coupon_url']['mobile'];
                }
                $favo->restTel = $restaurantArray[0]['tel'];
                $favo->restFlag = 1;
                $favo->save();
                DB::commit();
                $data = response()->json($restaurantArray[0]);
                return $data;
            } catch(\Exception $e) {
                DB::rollBack();
                logger($e);
                $dbErrorMessage = 'DB接続に失敗しました';
                logger($viewData);
                return $dbErrorMessage;
            }
        } else {
            //ログインしてない
            return view('main');
        }



    }

    //お気に入りリスト表示
    public function favoshow(){
        //ログインしているか確認
        if(Auth::check()){
             // クライアントの使用端末を判定
              // スマホ
            if(self::ua_smt() == true){
                $int = 4;
            }else{
                $int = 12;
            }
            DB::beginTransaction();
            try{
                $favoriteDatas = Favo::where('user_id',Auth::id())->paginate($int);
                DB::commit();
                return view('favo')->with('favoriteDatas',$favoriteDatas);
            } catch(Exception $e){
                DB::rollBack();
                return redirect()->to('errors/500');
            }
        }else {
            //ログインしてない場合
            return view('main');
        }
    }

    //お気に入りリスト削除
    public function favodelete(Request $request){
        //ログインしているか確認
        if(Auth::check()){
            // スマホ
            if(self::ua_smt() == true){
                $int = 4;
            }else{
                $int = 12;
            }
            DB::beginTransaction();
            try{
                Favo::where('restId',$request->restId)->delete();
                $favoriteDatas = Favo::where('user_id',Auth::id())->paginate($int);
                DB::commit();
                return view('favo')->with('favoriteDatas',$favoriteDatas);
            }catch(Exception $e){
                DB::rollBack();
                return redirect()->to('errors/500');
            }
        }
    }
    public static function ua_smt(){
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $ua_list = array('iPhone','iPad','iPod','Android');
        foreach($ua_list as $ua_smt) {
            if(strpos($ua,$ua_smt) !== false){
                return true;
            } else {
                return false;
            }
        }
    }
}
