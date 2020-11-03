<?php


namespace FetchFans\Platform;


use Exception;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class Weibo implements Base
{
    protected $nickname = '';

    protected $fans_count = 0;

    /**
     * @inheritDoc
     */
    public function fetch($url)
    {
        $uid = str_replace('https://weibo.com/u/','',$url);
        if(empty($uid)){
            throw new Exception('error uid');
        }
        $client = new Client();
        $response =  $client->get('https://m.weibo.cn/api/container/getIndex',[
            'query'=>[
                'type'=>'uid',
                'value'=>$uid
            ]
        ]);

        $response = $response->getBody()->getContents();
        $response = json_decode($response,true);

        if($response && $response['data']['userInfo'] && $response['data']['userInfo']['id'] == $uid ){
            $this->nickname = $response['data']['userInfo']['screen_name'];
            $this->fans_count = $response['data']['userInfo']['followers_count'];
            return true;
        }
        return false;

    }

    public function getFansCount()
    {
        return $this->fans_count;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function getLikeCount()
    {
        return 0;
    }
}