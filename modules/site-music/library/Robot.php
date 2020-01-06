<?php
/**
 * Robot
 * @package site-music
 * @version 0.0.1
 */

namespace SiteMusic\Library;

use Music\Model\Music;
use Music\Model\MusicAlbum as MAlbum;

class Robot
{
    static private function getAlbumPages(): ?array{
        $cond = [
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];

        $pages = MAlbum::get($cond);
        if(!$pages)
            return null;

        return $pages;
    }

    static private function getPages(object $album=null): ?array{
        $cond = [
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        if($album)
            $cond['album'] = $album->id;

        $pages = Music::get($cond);
        if(!$pages)
            return null;

        return $pages;
    }

    static function feedMusic(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('siteMusicSingle', (array)$page);
            $meta  = json_decode($page->meta);
            $title = $meta->title ?? $page->title;
            $desc  = $meta->description ?? substr($page->content, 0, 100);

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }

    static function feedMusicAlbum(object $album): array {
        $mim = &\Mim::$app;

        $pages = self::getPages($album);
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('siteMusicSingle', (array)$page);
            $meta  = json_decode($page->meta);
            $title = $meta->title ?? $page->title;
            $desc  = $meta->description ?? substr($page->content, 0, 100);

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }

    static function feedAlbum(): array {
        $mim = &\Mim::$app;

        $pages = self::getAlbumPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('siteMusicAlbumSingle', (array)$page);
            $meta  = json_decode($page->meta);
            $title = $meta->title ?? $page->name;
            $desc  = $meta->description ?? substr($page->content, 0, 100);

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }
}