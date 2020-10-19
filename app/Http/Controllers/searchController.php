<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Controllers\MainPageController as Main;

class searchController extends Controller
{
     const header = [
        'Origin'                    => 'https://google.com',
        'Accept-Encoding'           => 'gzip, deflate, br',
        'Accept-Language'           => 'ja,en-US;q=0.8,en;q=0.6',
        'Upgrade-Insecure-Requests' => '1',
        'Content-Type'              => 'application/json; charset=utf-8',
    ];
    //検索機能
    public function search(Request $request){
        if(!isset($request)){
            return view('main');
        }
        $searchword = str_replace('/[\p{Z}\p{Cc}]++/u',',',$request->searchword);
        $searchword = urldecode($request->searchword);
        $url = config('app.restSearchApiUrl');
        $query = [
            'keyid' => config('app.gurunavi_api_key'),
            'hit_per_page' => 10,
            'freeword' => $searchword
        ];
        $headers = Self::header;
        try{
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
             // API実行エラーの場合
            if ($responseData == "Client error") {
                return view('errors.404');
            }
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
            $usedTerminal = Main::isMobileOrPc($request->header('User-Agent'));
            if ($usedTerminal == 'pc') {
                $usedTerminal = array('terminal' => 1);
            } else {
                $usedTerminal =
                    array('terminal' => 2);
            }
             //エリアSマスタ情報API
            $GAreaSmallSearchData = Main::GAreaSmallSearchAPI();
            //大業態マスタ情報取得APi
            $CategoryLargeSearchData = Main::CategoryLargeSearchAPI();
            return view('main')
                ->with('viewData', $viewData)
                ->with('usedTerminal', $usedTerminal)
                ->with('GAreaSmallSearchData', $GAreaSmallSearchData)
                ->with('CategoryLargeSearchData', $CategoryLargeSearchData);
        }catch (\Exception $e) {
           $errorCode = $e->getCode();
           return Main::errorRedirect($errorCode);
        }


    }
    public static  function extractKeywords(string $input, int $limit = -1): array
        {
            return preg_split('/[\p{Z}\p{Cc}]++/u', $input, $limit, PREG_SPLIT_NO_EMPTY);
        }
}
