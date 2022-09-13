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

namespace FoF\Sitemap\Listeners;

use Flarum\Settings\Event\Saved;
use Flarum\Settings\Event\Saving;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Sitemap\Jobs\TriggerBuildJob;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Arr;

class SettingsListener
{
    protected $settings;
    protected $filesystem;

    public function __construct(SettingsRepositoryInterface $settings, Factory $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->settings   = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'whenSaving']);
        $events->listen(Saved::class, [$this, 'whenSaved']);
    }

    public function whenSaving(Saving $event)
    {
        $mode = Arr::get($event->settings, 'fof-sitemap.mode');
        $setting = $this->settings->get('fof-sitemap.mode');

        if ($mode === 'run' && $setting === 'multi-file') {
            $this->removeCachedSitemaps();
        }
    }

    public function whenSaved(Saved $event)
    {
        $mode = Arr::get($event->settings, 'fof-sitemap.mode');

        if ($mode === 'multi-file') {
            $this->createCachedSitemaps();
        }
    }

    private function removeCachedSitemaps()
    {
        $sitemapsDir = $this->filesystem->disk('flarum-sitemaps');

        $files = $sitemapsDir->allFiles();

        foreach ($files as $file) {
            $sitemapsDir->delete($file);
        }
    }

    private function createCachedSitemaps()
    {
        resolve('flarum.queue.connection')->push(new TriggerBuildJob());
    }
}
