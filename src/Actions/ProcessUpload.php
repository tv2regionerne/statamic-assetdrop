<?php

namespace Tv2regionerne\StatamicAssetdrop\Actions;

use Illuminate\Support\Facades\Storage;
use Statamic\Assets\AssetContainer;
use Statamic\Contracts\Assets\Asset;
use Statamic\Facades\Antlers;
use Statamic\Support\Str;
use Tv2regionerne\StatamicAssetdrop\Events\ExternalDocumentProcessed;
use Tv2regionerne\StatamicAssetdrop\Events\ExternalImageProcessed;
use Tv2regionerne\StatamicAssetdrop\Events\ExternalVideoProcessed;
use Tv2regionerne\StatamicAssetdrop\Events\StatamicDocumentProcessed;
use Tv2regionerne\StatamicAssetdrop\Events\StatamicImageProcessed;
use Tv2regionerne\StatamicAssetdrop\Events\StatamicVideoProcessed;

class ProcessUpload
{
    public function handle(Asset $asset)
    {
        $type = match (true) {
            $asset->isImage() => 'image',
            $asset->isVideo() => 'video',
            default => 'document',
        };

        $config = config('assetdrop.'.$type);
        if (! $config['enabled']) {
            return;
        }

        if ($config['statamic']['enabled'] ?? false) {
            $this->handleStatamic($type, $asset, $config['statamic']);
        }
        if ($config['external']['enabled'] ?? false) {
            $this->handleExternal($type, $asset, $config['external']);
        }

        if (config('assetdrop.remove_processed')) {
            $asset->delete();
        }
    }

    protected function handleStatamic($type, Asset $asset, $config)
    {
        $container = AssetContainer::find($config['container']);
        $disk = $container->disk()->filesystem();
        $path = $this->buildPath($asset, $config['path']);

        $disk->writeStream($path, $asset->stream());

        $newAsset = $container->asset($path);
        $newAsset->writeMeta($asset->meta());
        $newAsset->set('title', $newAsset->filename());
        $newAsset->set('tags', $config['tags']);
        $newAsset->save();

        match ($type) {
            'image' => StatamicImageProcessed::dispatch($asset, $newAsset),
            'video' => StatamicVideoProcessed::dispatch($asset, $newAsset),
            'document' => StatamicDocumentProcessed::dispatch($asset, $newAsset),
        };
    }

    protected function handleExternal($type, Asset $asset, $config)
    {
        $disk = Storage::disk($config['disk']);
        $path = $this->buildPath($asset, $config['path']);

        $disk->writeStream($path, $asset->stream());

        match ($type) {
            'image' => ExternalImageProcessed::dispatch($asset),
            'video' => ExternalVideoProcessed::dispatch($asset),
            'document' => ExternalDocumentProcessed::dispatch($asset),
        };
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
