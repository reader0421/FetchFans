<?php


namespace FetchFans\Platform;


use Exception;
use FetchFans\Util;
use PHPHtmlParser\Dom;

class RedBook implements Base
{
    protected $nickname = '';

    protected $fans_count = 0;

    protected $like_count = 0;

    /**
     * @inheritDoc
     */
    public function fetch($url)
    {
        $dom = new Dom();
        try{
            $dom->loadFromUrl($url);
        }catch (Exception $e){
            throw new Exception('redbook load url error:'.$e->getMessage());
        }


        //name
        $nickname = '';
        $div1 = $dom->find('.name-detail')[0];

        $nickname = $div1->text;
        if(empty($nickname)){
            throw new Exception('redbook get nickname error');
        }
        $this->nickname = $nickname;

        //fans
        $div2 = $dom->find('.info-number')[1];
        $fans = $div2->text;
        //有可能为0
        if($fans === ''){
            throw new Exception('redbook get fans error');
        }
        $this->fans_count = Util::numStr2Int($fans);

        //like
        $div3 = $dom->find('.info-number')[2];
        $like = $div3->text;
        //有可能为0
        if($like === ''){
            throw new Exception('redbook get like error');
        }
        $this->like_count = Util::numStr2Int($like);
        return true;
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