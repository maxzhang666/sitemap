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

namespace FoF\Sitemap\Sitemap;

use Carbon\Carbon;
use Illuminate\View\Factory;

class Sitemap
{
    public $sets;

    public function __construct(
        array $sets,
        Carbon $lastModified
    ) {
        $this->sets = $sets;
    }

    public function toXML(): string
    {
        $view = resolve(Factory::class);

        return $view->make('fof-sitemap::sitemap')->with('sitemap', $this)->render();
    }
}
