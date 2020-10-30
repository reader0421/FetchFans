<?php
namespace FetchFans;

use Exception;
use FetchFans\Platform\Base;

class Fetch
{
    /**
     * 昵称
     * @var string
     */
    protected $nickname = '';

    /**
     * 粉丝数
     * @var int
     */
    protected $fans_count = 0;

    /**
     * 目标的分享链接
     * @var string
     */
    protected $share_url = '';

    /**
     * 自媒体平台
     * @var Base
     */
    protected $platform;

    protected $error = 'ok';


    public function __construct($share_url,Base $platform)
    {
        $this->platform = $platform;

        $this->share_url = Util::str2url($share_url);


    }

    public function fetch()
    {
        if(empty($this->share_url)){
            $this->error = 'url error';
            return false;
        }

        try{

            $this->platform->fetch($this->share_url);
            $this->fans_count  = $this->platform->getFansCount();
            $this->nickname = $this->platform->getNickname();
            return true;

        }catch (Exception $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getNickName()
    {
        return $this->nickname;
    }

    public function getFansCount()
    {
        return $this->fans_count;
    }

    public function getError()
    {
        return $this->error;
    }




}