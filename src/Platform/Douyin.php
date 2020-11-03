<?php
namespace FetchFans\Platform;
use Exception;
use FetchFans\Util;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

/**
 * 获取抖音账号粉丝数
 * Class Douyin
 */
class Douyin implements Base
{
    protected $nickname = '';

    protected $fans_count = 0;

    protected $like_count = 0;

    public function getFansCount()
    {
        return $this->fans_count;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function fetch($url)
    {
        //$url = 'https://v.douyin.com/JkgpaDH/';

        /**
         * 抖音会做一次跳转
         */
        $dom = new Dom();
        try{
            $dom->loadFromUrl($url);
        }catch (Exception $e){
            throw new Exception('douyin load url error:'.$e->getMessage());
        }
        $a = $dom->find('a')[0];

        $tag = $a->getTag();
        $t_url = $tag->getAttribute('href')->getValue();
        if(empty($t_url)){
            throw new Exception('douyin get url error');
        }

        $query_url = parse_url($t_url)['query'];
        $tmp = explode(';',$query_url);
        if (empty($tmp)){
            throw new Exception('douyin get jump url error');
        }
        $query = [];
        foreach ($tmp as $v){
            $vv = explode('=',$v);
            $query[$vv[0]] = $vv[1];
        }

        $client = new Client();
        $res = $client->request(
            'GET',
            'https://www.iesdouyin.com/web/api/v2/user/info/?sec_uid='.$query['sec_uid']
        );
        $res = $res->getBody()->getContents();
        $res = json_decode($res,true);
        if(!isset($res['user_info'])){
            throw new Exception('douyin get user data error');
        }
        if(!isset($res['user_info']['nickname'])){
            throw new Exception('douyin get nickname error');
        }
        $this->nickname = $res['user_info']['nickname'];
        if(!isset($res['user_info']['follower_count'])){
            throw new Exception('douyin get follower_count error');
        }
        $this->fans_count = Util::numStr2Int($res['user_info']['follower_count']);

        if(!isset($res['user_info']['total_favorited'])){
            throw new Exception('douyin get total_favorited error');
        }
        $this->like_count = Util::numStr2Int($res['user_info']['total_favorited']);

        return true;
    }

    public function getLikeCount()
    {
        return $this->like_count;
    }
}