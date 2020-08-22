<?php
/**
 * Meta
 * @package site-music
 * @version 0.0.1
 */

namespace SiteMusic\Library;


class Meta
{
    static function musicIndex($musics, $total): array{
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        $def_meta = (object)[
            'title'         => \Mim::$app->setting->music_index_title,
            'description'   => \Mim::$app->setting->music_index_description,
            'schema'        => 'MusicPlaylist',
            'keyword'       => ''
        ];

        $result['head'] = [
            'description'       => $def_meta->description,
            'schema.org'        => [],
            'type'              => 'website',
            'title'             => $def_meta->title,
            'url'               => \Mim::$app->router->to('siteMusic'),
            'metas'             => []
        ];

        $result['head']['schema.org'][] = [
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => $home_url,
                        'name' => \Mim::$app->config->name
                    ]
                ]
            ]
        ];

        // schema page
        $music_scheme = [
            '@context'      => 'http://schema.org',
            '@type'         => $def_meta->schema,
            'name'          => $def_meta->title,
            'numTracks'     => $total
        ];
        
        $result['head']['schema.org'][] = $music_scheme;

        return $result;
    }

    static function albumSingle(object $album): array{
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        // reset meta
        if(!is_object($album->meta))
            $album->meta = (object)[];

        $def_meta = [
            'title'         => $album->name,
            'description'   => $album->content->chars(160),
            'schema'        => 'MusicAlbum',
            'keyword'       => ''
        ];

        foreach($def_meta as $key => $value){
            if(!isset($album->meta->$key) || !$album->meta->$key)
                $album->meta->$key = $value;
        }

        $result['head'] = [
            'description'       => $album->meta->description,
            'published_time'    => $album->created,
            'schema.org'        => [],
            'type'              => 'website',
            'title'             => $album->meta->title,
            'updated_time'      => $album->updated,
            'url'               => $album->page,
            'metas'             => []
        ];

        // schema breadcrumbList
        $music_album_url = $home_url . '#music-album';
        if(\Mim::$app->config->music->index)
            $music_album_url = \Mim::$app->router->to('siteMusic');

        $result['head']['schema.org'][] = [
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => $home_url,
                        'name' => \Mim::$app->config->name
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => $music_album_url,
                        'name' => 'Music Albums'
                    ]
                ]
            ]
        ];

        // schema page
        $result['head']['schema.org'][] = [
            '@context'      => 'http://schema.org',
            '@type'         => $album->meta->schema,
            'name'          => $album->meta->title,
            'description'   => $album->meta->description,
            'dateCreated'   => $album->created,
            'dateModified'  => $album->updated,
            'datePublished' => $album->created,
            'publisher'     => \Mim::$app->meta->schemaOrg( \Mim::$app->config->name ),
            // 'thumbnailUrl'  => $meta_image,
            'url'           => $album->page,
            // 'image'         => $meta_image
        ];

        return $result;
    }

    static function musicSingle(object $music){
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        // reset meta
        if(!is_object($music->meta))
            $music->meta = (object)[];

        $def_meta = [
            'title'         => $music->title,
            'description'   => $music->content->chars(160),
            'schema'        => 'MusicRecording',
            'keyword'       => ''
        ];

        foreach($def_meta as $key => $value){
            if(!isset($music->meta->$key) || !$music->meta->$key)
                $music->meta->$key = $value;
        }

        $result['head'] = [
            'description'       => $music->meta->description,
            'published_time'    => $music->created,
            'schema.org'        => [],
            'type'              => 'website',
            'title'             => $music->meta->title,
            'updated_time'      => $music->updated,
            'url'               => $music->page,
            'metas'             => []
        ];

        // schema breadcrumbList
        $music_url = $home_url . '#music';
        if(\Mim::$app->config->music->index)
            $music_url = \Mim::$app->router->to('siteMusic');

        $result['head']['schema.org'][] = [
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => $home_url,
                        'name' => \Mim::$app->config->name
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => $music_url,
                        'name' => 'Musics'
                    ]
                ]
            ]
        ];

        // schema page
        $result['head']['schema.org'][] = [
            '@context'      => 'http://schema.org',
            '@type'         => $music->meta->schema,
            'name'          => $music->meta->title,
            'description'   => $music->meta->description,
            'dateCreated'   => $music->created,
            'dateModified'  => $music->updated,
            'datePublished' => $music->created,
            'publisher'     => \Mim::$app->meta->schemaOrg( \Mim::$app->config->name ),
            // 'thumbnailUrl'  => $meta_image,
            'url'           => $music->page,
            // 'image'         => $meta_image
        ];

        return $result;
    }
}