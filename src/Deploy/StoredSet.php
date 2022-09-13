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

namespace FoF\Sitemap\Deploy;

use Carbon\Carbon;

class StoredSet
{
    public $url;
    public $lastModifiedAt;

    public function __construct(
        string $url,
        Carbon $lastModifiedAt
    )
    {
        $this->lastModifiedAt = $lastModifiedAt;
        $this->url            = $url;
    }
}
