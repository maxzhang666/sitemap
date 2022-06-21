<?php

/*
 * This file is part of fof/sitemap.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace FoF\Sitemap;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\Foundation\Paths;
use Flarum\Http\UrlGenerator;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Routes('forum'))
        ->get('/sitemap-live/{id}', 'fof-sitemap-live', Controllers\MemoryController::class)
        ->get('/sitemap.xml', 'fof-sitemap-index', Controllers\SitemapController::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(ForumAttributes::class),

    (new Extend\ServiceProvider())
        ->register(Providers\Provider::class)
        ->register(Providers\DeployProvider::class),

    (new Extend\Console())
        ->command(Console\BuildSitemapCommand::class)
        ->schedule(Console\BuildSitemapCommand::class, new Console\BuildSitemapSchedule()),

    (new Extend\View())
        ->namespace('fof-sitemap', __DIR__.'/views'),

    (new Extend\Filesystem())
        ->disk('flarum-sitemaps', function (Paths $paths, UrlGenerator $url) {
            return [
                'root'   => "$paths->public/sitemaps",
                'url'    => $url->to('forum')->path('sitemaps'),
            ];
        }),
];
