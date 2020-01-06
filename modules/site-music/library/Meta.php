<?php
/**
 * Meta
 * @package site-music
 * @version 0.0.1
 */

namespace SiteMusic\Library;


class Meta
{
    static function albumSingle(object $album){
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
                        '@id' => $home_url . '#music-album',
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
                        '@id' => $home_url . '#music',
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