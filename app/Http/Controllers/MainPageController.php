<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{
    // ヘッダー
    const header = [
        'Origin'                    => 'https://google.com',
        'Accept-Encoding'           => 'gzip, deflate, br',
        'Accept-Language'           => 'ja,en-US;q=0.8,en;q=0.6',
        'Upgrade-Insecure-Requests' => '1',
        'Content-Type'              => 'application/json; charset=utf-8',
    ];
    //メインページの表示
    public function index(Request $request)
    {

        //レストランデータの取得
        $responseData = self::getRestaurantData();
        //エリアSマスタ情報API
        $GAreaSmallSearchData = self::GAreaSmallSearchAPI();
        //大業態マスタ情報取得APi
        $CategoryLargeSearchData = self::CategoryLargeSearchAPI();

        // クライアントの使用端末を判定
        $usedTerminal = self::isMobileOrPc($request->header('User-Agent'));
        if ($usedTerminal == 'pc') {
            $usedTerminal = array('terminal' => 1);
        } else {
            $usedTerminal =
                array('terminal' => 2);
        }

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

        // 会員登録しているか判定
        $data = self::userStatus();
        $userData = json_encode($data);

        // 広告用データランダム表示用
        $advertising = mt_rand(1,8);
        return view('main')
        ->with('viewData', $viewData)
        ->with('usedTerminal', $usedTerminal)
        ->with('GAreaSmallSearchData', $GAreaSmallSearchData)
        ->with('CategoryLargeSearchData', $CategoryLargeSearchData)
        ->with('userData',$userData)
        ->with('advertising',$advertising);

    }
    public static function getRestaurantData($restId = null)
    {
        try {
            /**
             * guzzleHttpClientによるAPI実行
             * /RestSearchAPI/:レストラン検索API
             * keyid:アクセスキー
             * address:地名
             * areacode_m:エリアコード
             * category_l:大業態/RSFST21000=お酒
             **/
            $url = config('app.restSearchApiUrl');

            $query = [
                'keyid' => config('app.gurunavi_api_key'),
                'hit_per_page' => 10,
            ];
            //お気に入り登録の場合id追加
            if(isset($restId)){
                unset($query['hit_per_page']);
                $query['hit_per_page'] = 1;
                $query['id'] = $restId;
            }
            $headers = Self::header;
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                'GET',
                $url,
                [
                    'query' => $query,
                    'headers' => $headers
                ]
            );
            $responseBody = (string)$response->getBody();
            $responseData = json_decode($responseBody, true);

            // クライアントエラーチェック
            $isClientError = array_key_exists('error', $responseData);
            if ($isClientError) {
                $responseData = "Client error";
            }
            return $responseData;
        } catch (\Exception $e) {
           $errorCode = $e->getCode();
           return self::errorRedirect($errorCode);
        }
    }
    /**
     * guzzleHttpClientによるAPI実行
     * /GAreaSmallSearchAPI/:エリアSマスタ取得API
     * keyid:アクセスキー
     **/
    public static function GAreaSmallSearchAPI()
    {
        try {
            $param = array(
                'keyid' => config('app.gurunavi_api_key'),
            );
            $headers = Self::header;
            $apiUrl = config('app.GAreaSmallSearchUrl');
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                'GET',
                $apiUrl,
                [
                    'query' => $param,
                    'headers' => $headers
                ]
            );
            /**
             * レスポンスボディ取得
             * json形式を配列に変換
             */
            $responseBody = (string)$response->getBody();
            $GAreaSmallSearchData = json_decode($responseBody, true);
            return $GAreaSmallSearchData;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            return self::errorRedirect($errorCode);
        }
    }
    /**
     * guzzleHttpClientによるAPI実行
     * /GAreaSmallSearchAPI/:エリアSマスタ取得API
     * keyid:アクセスキー
     **/
    public static function CategoryLargeSearchAPI()
    {
        try {
            $param = array(
                'keyid' => config('app.gurunavi_api_key'),
            );
            $headers = Self::header;
            $apiUrl = config('app.CategoryLargeSearchUrl');
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                'GET',
                $apiUrl,
                [
                    'query' => $param,
                    'headers' => $headers
                ]
            );

            /**
             * レスポンスボディ取得
             * json形式を配列に変換
             */
            $responseBody = (string)$response->getBody();
            $CategoryLargeSearchData = json_decode($responseBody, true);
            return $CategoryLargeSearchData;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            return self::errorRedirect($errorCode);
        }
    }
    /**
     * クライアントの使用端末を判定
     * @param $userAgent
     * @return string
     * @access public
     */
    public static function isMobileOrPc($userAgent): string
    {
        if ((strpos($userAgent, 'iPhone') !== false)
            || (strpos($userAgent, 'iPod') !== false)
            || (strpos($userAgent, 'Android') !== false)
        ) {
            return 'mobile';
        } else {
            return 'pc';
        }
    }
    /**
     * 条件絞り込み検索
     * @param $request
     * @return string
     * @access public
     */
    public static function conditions(Request $request)
    {
        try {
            /**
             * guzzleHttpClientによるAPI実行
             * /RestSearchAPI/:レストラン検索API
             * keyid:アクセスキー
             * rareacode_s:検索エリア
             * category_l:ジャンル・食べ物
             * longitude:
             **/
            $query = array(
                'keyid' => config('app.gurunavi_api_key'),
                'areacode_s' => $request->areacode_s,
                'category_l' => $request->category_l,
            );
            if ($request->card != null) {
                $query['card'] = $request->card;
            }
            if ($request->bottomless_cup != null) {
                $query['bottomless_cup'] = $request->bottomless_cup;
            }
            if ($request->no_smoking != null) {
                $query['no_smoking'] = $request->no_smoking;
            }
            if ($request->private_room != null) {
                $query['private_room'] = $request->private_room;
            }
            if ($request->buffet != null) {
                $query['buffet'] = $request->buffet;
            }
            if ($request->parking != null) {
                $query['parking'] = $request->parking;
            }
            if ($request->midnight != null) {
                $query['midnight'] = $request->midnight;
            }
            $headers = Self::header;
            $apiUrl = config('app.restSearchApiUrl');
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                'GET',
                $apiUrl,
                [
                    'query' => $query,
                    'headers' => $headers
                ]
            );
            // 形式変換
            $responseBody = (string)$response->getBody();
            $responseData = json_decode($responseBody, true);
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
            // クライアントの使用端末を判定
            $usedTerminal = self::isMobileOrPc($request->header('User-Agent'));
            if ($usedTerminal == 'pc') {
                $usedTerminal = array('terminal' => 1);
            } else {
                $usedTerminal =
                    array('terminal' => 2);
            }

            //エリアSマスタ情報API(Controllerクラス再利用)
            $GAreaSmallSearchData = self::GAreaSmallSearchAPI();
            //大業態マスタ情報取得APi(Controllerクラス再利用)
            $CategoryLargeSearchData = self::CategoryLargeSearchAPI();
            //会員か確認
            $data = self::userStatus();
            $userData = json_encode($data);
            // 広告用データランダム表示用
            $advertising = mt_rand(1,8);

            return view('main')
                ->with('viewData', $viewData)
                ->with('usedTerminal', $usedTerminal)
                ->with('GAreaSmallSearchData', $GAreaSmallSearchData)
                ->with('CategoryLargeSearchData', $CategoryLargeSearchData)
                ->with('userData',$userData)
                ->with('advertising',$advertising);
        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            return self::errorRedirect($errorCode);
        }
    }

    // フリーワード検索
    public static function freeword(Request $request)
    {
        try {
            // クエリを用意
            $query = [
                'keyid' => config('app.gurunavi_api_key'),
                'hit_per_page' => 10,
            ];
            // フリーワード
            $freeWordList = $request->freeword;
            //配列をクエリの形式に
            $freeWordList = str_replace('、', ',', $freeWordList);
            //クエリにフリーワードを追加
            $query['freeword'] = $freeWordList;
            $headers = Self::header;
            $apiUrl = config('app.restSearchApiUrl');
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                'GET',
                $apiUrl,
                [
                    'query' => $query,
                    'headers' => $headers
                ]
            );
            // レスポンスボディを取得
            $responseBody = (string)$response->getBody();
            //json→配列にデコード
            $responseData = json_decode($responseBody, true);
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
            // クライアントの使用端末を判定
            $usedTerminal = self::isMobileOrPc($request->header('User-Agent'));
            if ($usedTerminal == 'pc') {
                $usedTerminal = array('terminal' => 1);
            } else {
                $usedTerminal =
                    array('terminal' => 2);
            }
            //エリアSマスタ情報API
            $GAreaSmallSearchData = self::GAreaSmallSearchAPI();
            //大業態マスタ情報取得APi
            $CategoryLargeSearchData = self::CategoryLargeSearchAPI();
            //会員か確認
            $data = self::userStatus();
            $userData = json_encode($data);
            // 広告用データランダム表示用
            $advertising = mt_rand(1,8);
            return view('main')
                ->with('viewData',$viewData)
                ->with('usedTerminal', $usedTerminal)
                ->with('GAreaSmallSearchData', $GAreaSmallSearchData)
                ->with('CategoryLargeSearchData', $CategoryLargeSearchData)
                ->with('userData',$userData)
                ->with('advertising',$advertising);
        } catch (\Exception $e) {
           $errorCode = $e->getCode();
           return self::errorRedirect($errorCode);
        }
    }

    //現在地から検索
    public static function locationinfomation(Request $request)
    {
        try {
            // クエリを用意
            $query = [
                'keyid' => config('app.gurunavi_api_key'),
                'hit_per_page' => 10,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            $headers = Self::header;
            $apiUrl = config('app.restSearchApiUrl');
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                'GET',
                $apiUrl,
                [
                    'query' => $query,
                    'headers' => $headers
                ]
            );
            // レスポンスボディを取得
            $responseBody = (string)$response->getBody();
            //json→配列にデコード
            $responseData = json_decode($responseBody, true);
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
            // クライアントの使用端末を判定
            $usedTerminal = self::isMobileOrPc($request->header('User-Agent'));
            if ($usedTerminal == 'pc') {
                $usedTerminal = array('terminal' => 1);
            } else {
                $usedTerminal =
                    array('terminal' => 2);
            }
            //エリアSマスタ情報API
            $GAreaSmallSearchData = self::GAreaSmallSearchAPI();
            //大業態マスタ情報取得APi
            $CategoryLargeSearchData = self::CategoryLargeSearchAPI();
            //会員か確認
            $data = self::userStatus();
            $userData = json_encode($data);
            // 広告用データランダム表示用
            $advertising = mt_rand(1,8);
            return view('main')
                ->with(
                    'viewData',
                    $viewData
                )
                ->with('usedTerminal', $usedTerminal)
                ->with('GAreaSmallSearchData', $GAreaSmallSearchData)
                ->with('CategoryLargeSearchData', $CategoryLargeSearchData)
                ->with('userData',$userData)
                ->with('advertising',$advertising);
        } catch (\Exception $e) {
            $errorCode = $e->getCode();
            return self::errorRedirect($errorCode);
        }
    }
    // エラー遷移
    public static function errorRedirect($errorCode){
        switch ($errorCode) {
                case '403':
                    return redirect()->to('errors/403');
                    break;
                case '404':
                    return redirect()->to('errors/404');
                    break;
                case '405':
                    return redirect()->to('errors/405');
                    break;
                case '406':
                    return redirect()->to('errors/406');
                    break;
                case '407':
                    return redirect()->to('errors/407');
                    break;
                case '408':
                    return redirect()->to('errors/408');
                    break;
                default:
                    return redirect()->to('errors/500');
                    break;
            }
    }
    public static function userStatus(){
        if(Auth::check()){
            $user = Auth::user();
            return $user;
        } else {
            $guestStatus =  ['status' => 'guest'];
            return $guestStatus;
        }
    }
}
