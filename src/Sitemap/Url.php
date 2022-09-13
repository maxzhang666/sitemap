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

class Url
{
    public $location;
    public $lastModified = null;
    public $changeFrequency = null;
    public $priority = null;

    public function __construct(
        string $location,
        Carbon $lastModified = null,
        string $changeFrequency = null,
        float  $priority = null
    )
    {
        $this->priority        = $priority;
        $this->changeFrequency = $changeFrequency;
        $this->lastModified    = $lastModified;
        $this->location        = $location;
    }

    public function toXML(Factory $view): string
    {
        return $view->make('fof-sitemap::url')->with('url', $this)->render();
    }
}
