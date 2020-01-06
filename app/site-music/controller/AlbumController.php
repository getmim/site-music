<?php
/**
 * AlbumController
 * @package site-music
 * @version 0.0.1
 */

namespace SiteMusic\Controller;

use SiteMusic\Library\Meta;
use Music\Model\Music;
use Music\Model\MusicAlbum as MAlbum;
use LibFormatter\Library\Formatter;

class AlbumController extends \Site\Controller
{
    public function singleAction(){
        $slug = $this->req->param->slug;

        $album = MAlbum::getOne(['slug'=>$slug]);
        if(!$album)
            return $this->show404();

        $album = Formatter::format('music-album', $album, ['user']);

        $params = [
            'album' => $album,
            'songs' => [],
            'meta'  => Meta::albumSingle($album)
        ];

        $songs = Music::get(['album' => $album->id]);
        if($songs)
            $params['songs'] = Formatter::formatMany('music', $songs);

        $this->res->render('music/album', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }
}