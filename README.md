# site-music

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install site-music
```

## Event Listener

1. `music:created` `(object $page)`
1. `music:deleted` `(object $page)`
1. `music:updated` `(object $page)`
1. `music-album:created` `(object $page)`
1. `music-album:deleted` `(object $page)`
1. `music-album:updated` `(object $page)`

## EndPoints

### `GET /music/feed.xml`

### `GET /music/listen/(:slug)`

### `GET /music/album/(:slug)`

### `GET /music/album/(:slug)/feed.xml`