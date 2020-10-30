<?php


namespace FetchFans;


class Util
{
    /**
     * 把粉丝数转换为数字
     * 类似 10W粉丝
     * @param $num
     * @return float|int
     */
    public static function numStr2Int($num)
    {
        //粉丝过万
        $res = stristr($num,'w',true);
        if($res){
            return $res*10000;
        }
        return intval($num);
    }

    /**
     * 提取分享内容中的URL
     * @param $str
     * @return mixed|string
     */
    public static function str2url($str)
    {
        preg_match_all('/https?:\/\/[\w.\/\?=&#@\-\|;]+/',$str,$url);
        if(empty($url[0]) || empty($url[0][0])){
            return '';
        }
        return $url[0][0];
    }
}