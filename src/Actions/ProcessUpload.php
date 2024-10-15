<?php

namespace Tv2regionerne\StatamicAssetdrop\Actions;

use Illuminate\Support\Facades\Storage;
use Statamic\Assets\AssetContainer;
use Statamic\Contracts\Assets\Asset;
use Statamic\Facades\Antlers;
use Statamic\Support\Str;

class ProcessUpload
{
    public function handle(Asset $asset)
    {
        $config = match (true) {
            $asset->isImage() => config('assetdrop.image'),
            $asset->isVideo() => config('assetdrop.video'),
            default => config('assetdrop.document'),
        };

        if (! $config['enabled']) {
            return;
        }

        if ($config['statamic']['enabled'] ?? false) {
            $this->handleStatamic($asset, $config['statamic']);
        }
        if ($config['external']['enabled'] ?? false) {
            $this->handleExternal($asset, $config['external']);
        }
        if ($config['kaltura']['enabled'] ?? false) {
            $this->handleKaltura($asset, $config['kaltura']);
        }

        $asset->delete();
    }

    protected function handleStatamic(Asset $asset, $config)
    {
        $container = AssetContainer::find($config['container']);
        $disk = $container->disk()->filesystem();
        $path = $this->buildPath($asset, $config['path']);

        $disk->writeStream($path, $asset->stream());

        $newAsset = $container->asset($path);
        $newAsset->writeMeta($asset->meta());
        $newAsset->set('tags', $config['tags']);
        $newAsset->save();
    }

    protected function handleExternal(Asset $asset, $config)
    {
        $disk = Storage::disk($config['disk']);
        $path = $this->buildPath($asset, $config['path']);

        $disk->writeStream($path, $asset->stream());
    }

    protected function handleKaltura(Asset $asset, $config)
    {
        // Handle kaltura?
    }

    protected function buildPath(Asset $asset, $template)
    {
        $path = Antlers::parse($template, $asset->toAugmentedArray());

        return Str::of($path)
            ->explode('/')
            ->map(function ($segment) {
                return mb_ereg_replace('([\.]{2,})', '', mb_ereg_replace('([^\w\s\d\-~,;\[\]\(\).])', '', $segment));
            })
            ->implode('/');

    }
}
