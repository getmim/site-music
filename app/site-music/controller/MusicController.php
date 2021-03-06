<?php
/**
 * MusicController
 * @package site-music
 * @version 0.0.1
 */

namespace SiteMusic\Controller;

use SiteMusic\Library\Meta;
use Music\Model\Music;
use LibFormatter\Library\Formatter;

class MusicController extends \Site\Controller
{

    public function indexAction(){
        if(!$this->config->music->index)
            return $this->show404();

        $cond =  [];

        $musics = Music::get($cond, 0, 1, ['title'=>true]);
        if($musics)
            $musics = Formatter::formatMany('music', $musics, ['album', 'user']);

        $total = Music::count($cond);

        $params = [
            'meta'  => Meta::musicIndex($musics, $total),
            'total' => $total,
            'musics' => $musics
        ];

        $this->res->render('music/index', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }
    
    public function singleAction(){
        $slug = $this->req->param->slug;

        $music = Music::getOne(['slug'=>$slug]);
        if(!$music)
            return $this->show404();

        $music = Formatter::format('music', $music, ['album','user']);

        $params = [
            'music' => $music,
            'songs' => [],
            'meta'  => Meta::musicSingle($music)
        ];

        if($music->album && isset($music->album->id)){
            $songs = Music::get(['album' => $music->album->id]);
            if($songs)
                $params['songs'] = Formatter::formatMany('music', $songs);
        }

        $this->res->render('music/single', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }
}