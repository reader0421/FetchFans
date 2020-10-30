<?php


namespace FetchFans\Platform;


interface Base
{
    /**
     * 获取信息
     * @param $url
     * @return mixed
     */
    public function fetch($url);

    /**
     * 获取昵称
     * @return string
     */
    public function getNickname();

    /**
     * 获取粉丝数
     * @return int
     */
    public function getFansCount();
}