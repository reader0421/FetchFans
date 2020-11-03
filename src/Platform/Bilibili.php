<?php
namespace FetchFans\Platform;
use Exception;
use FetchFans\Util;
use GuzzleHttp\Client;

/**
 * 获取B站账号粉丝数
 * Class Bilibili
 */
class Bilibili implements Base
{
    protected $nickname = '';

    protected $fans_count = 0;

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
        $query_url = parse_url($url);
        if(!isset($query_url['path'])){
            throw new Exception('bilibili get url error');
        }

        if(!isset($query_url['host']) || $query_url['host'] != 'space.bilibili.com'){
            throw new Exception('bilibili url error');
        }

        $path = $query_url['path'];
        $id = str_replace('/','',$query_url['path']);
        if(empty($id)){
            throw new Exception('bilibili get id error');
        }
        //nickname
        $client = new Client();
        $res = $client->request(
            'GET',
            'https://api.bilibili.com/x/space/acc/info?mid='.$id
        );
        $res = $res->getBody()->getContents();
        $res = json_decode($res,true);
        if(!isset($res['data']['name'])){
            throw new Exception('bilibili get nickname error');
        }
        $this->nickname = $res['data']['name'];

        //fans
        try{
            $res = $client->request(
                'GET',
                'https://api.bilibili.com/x/relation/stat?vmid='.$id
            );
            $res = $res->getBody()->getContents();
            $res = json_decode($res,true);
        }catch (\Exception $e){
            throw new Exception('bilibili load url error:'.$e->getMessage());
        }

        if(!isset($res['data']['follower'])){
            throw new Exception('bilibili get fans error');
        }

        $this->fans_count = Util::numStr2Int($res['data']['follower']);

        return true;
    }

    public function getLikeCount()
    {
        return 0;
    }
}