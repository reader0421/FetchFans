<?php

use FetchFans\Fetch;
use FetchFans\Platform\Bilibili;
use FetchFans\Platform\Douyin;
use FetchFans\Platform\RedBook;
use FetchFans\Platform\Weibo;

require_once './vendor/autoload.php';

$douyin_share_url = '在抖音，记录美好生活！ https://v.douyin.com/Ja5e7jH/';
$redbook_url = 'https://www.xiaohongshu.com/user/profile/5ebab7260000000001001f12?xhsshare=CopyLink&appuid=5ebab7260000000001001f12&apptime=1604043658';
$bilibili_url = 'https://space.bilibili.com/678756538?share_medium=android&share_source=copy_link&bbid=XYBF5AABF7216AE77FD9A3AED4950C10B6FE4&ts=1604043949664';
$weinbo_url = 'https://weibo.com/u/3868613846';

//有可能还会有未知错误，用try catch走一下
//https 的连接 需要 curl 证书
try {
    $FetchFans = new Fetch($douyin_share_url, new Douyin());
    $res = $FetchFans->fetch();
    if (false === $res) {
        throw new Exception($FetchFans->getError());
    }
    echo 'nickname:' . $FetchFans->getNickName();
    echo "\r\n";
    echo 'fans count:' . $FetchFans->getFansCount();
    echo "\r\n";
    echo 'like count:' . $FetchFans->getLikeCount();

} catch (Exception $e) {
    echo 'fetch fail:' . urldecode($e->getMessage());
}
