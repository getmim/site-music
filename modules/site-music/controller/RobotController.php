<?php
/**
 * RobotController
 * @package site-music
 * @version 0.0.1
 */

namespace SiteMusic\Controller;

use LibRobot\Library\Feed;
use SiteMusic\Library\Robot;
use Music\Model\MusicAlbum as MAlbum;

class RobotController extends \Site\Controller
{
    public function feedMusicAction(){
        $links = Robot::feedMusic();

        $feed_opts = (object)[
            'self_url'          => $this->router->to('siteMusicFeed'),
            'copyright_year'    => date('Y'),
            'copyright_name'    => \Mim::$app->config->name,
            'description'       => '...',
            'language'          => 'id-ID',
            'host'              => $this->router->to('siteHome'),
            'title'             => \Mim::$app->config->name
        ];

        Feed::render($links, $feed_opts);
        $this->res->setCache(3600);
        $this->res->send();
    }

    public function feedAlbumAction(){
        $slug  = $this->req->param->slug;
        $album = MAlbum::getOne(['slug'=>$slug]);
        if(!$album)
            return $this->show404();

        $links = Robot::feedMusicAlbum($album);

        $feed_opts = (object)[
            'self_url'          => $this->router->to('siteMusicAlbumFeed', ['slug'=>$slug]),
            'copyright_year'    => date('Y'),
            'copyright_name'    => \Mim::$app->config->name,
            'description'       => '...',
            'language'          => 'id-ID',
            'host'              => $this->router->to('siteHome'),
            'title'             => \Mim::$app->config->name
        ];

        Feed::render($links, $feed_opts);
        $this->res->setCache(3600);
        $this->res->send();
    }
}