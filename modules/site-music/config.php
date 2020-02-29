<?php

return [
    '__name' => 'site-music',
    '__version' => '0.0.4',
    '__git' => 'git@github.com:getmim/site-music.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/site-music' => ['install','update','remove'],
        'theme/site/music' => ['install','remove'],
        'app/site-music' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'music' => NULL
            ],
            [
                'lib-formatter' => NULL
            ],
            [
                'site' => NULL
            ],
            [
                'site-meta' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-event' => NULL
            ],
            [
                'lib-cache-output' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SiteMusic\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-music/controller','app/site-music/controller']
            ],
            'SiteMusic\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-music/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteMusicSingle' => [
                'path' => [
                    'value' => '/music/listen/(:slug)',
                    'params' => [
                        'slug' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMusic\\Controller\\Music::single'
            ],
            'siteMusicAlbumSingle' => [
                'path' => [
                    'value' => '/music/album/(:slug)',
                    'params' => [
                        'slug' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMusic\\Controller\\Album::single'
            ],
            'siteMusicFeed' => [
                'path' => [
                    'value' => '/music/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteMusic\\Controller\\Robot::feedMusic'
            ],
            'siteMusicAlbumFeed' => [
                'path' => [
                    'value' => '/music/album/(:slug)/feed.xml',
                    'params' => [
                        'slug' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMusic\\Controller\\Robot::feedAlbum'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'music' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteMusicSingle',
                        'params' => [
                            'slug' => '$slug'
                        ]
                    ]
                ]
            ],
            'music-album' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteMusicAlbumSingle',
                        'params' => [
                            'slug' => '$slug'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'music:created' => [
                'SiteMusic\\Library\\Event::clearMusic' => TRUE
            ],
            'music:deleted' => [
                'SiteMusic\\Library\\Event::clearMusic' => TRUE
            ],
            'music:updated' => [
                'SiteMusic\\Library\\Event::clearMusic' => TRUE
            ],
            'music-album:created' => [
                'SiteMusic\\Library\\Event::clearAlbum' => TRUE
            ],
            'music-album:deleted' => [
                'SiteMusic\\Library\\Event::clearAlbum' => TRUE
            ],
            'music-album:updated' => [
                'SiteMusic\\Library\\Event::clearAlbum' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteMusic\\Library\\Robot::feedMusic' => TRUE,
                'SiteMusic\\Library\\Robot::feedAlbum' => TRUE
            ],
            'sitemap' => [
                'SiteMusic\\Library\\Robot::sitemapMusic' => TRUE,
                'SiteMusic\\Library\\Robot::sitemapAlbum' => TRUE
            ]
        ]
    ]
];
