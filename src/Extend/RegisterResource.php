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

namespace FoF\Sitemap\Extend;

use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use FoF\Sitemap\Resources\Resource;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class RegisterResource implements ExtenderInterface
{
    private $resource;

    /**
     * Add a resource from the sitemap. Specify the ::class of the resource.
     * Resource must extend FoF\Sitemap\Resources\Resource.
     *
     * @param string $resource
     */
    public function __construct(
        string $resource
    ) {
        $this->resource = $resource;
    }

    public function extend(Container $container, Extension $extension = null)
    {
        $container->extend('fof-sitemaps.resources', function (array $resources) {
            $this->validateResource();

            $resources[] = $this->resource;

            return $resources;
        });
    }

    private function validateResource()
    {
        foreach (class_parents($this->resource) as $class) {
            if ($class === Resource::class) {
                return;
            }
        }

        throw new InvalidArgumentException("{$this->resource} has to extend ".Resource::class);
    }
}
