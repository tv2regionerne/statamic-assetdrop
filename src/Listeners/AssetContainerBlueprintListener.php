<?php

namespace Tv2regionerne\StatamicAssetdrop\Listeners;

use Statamic\Events\AssetContainerBlueprintFound;
use Statamic\Support\Arr;

class AssetContainerBlueprintListener
{
    public function handle(AssetContainerBlueprintFound $event): void
    {
        $blueprint = $event->blueprint;
        $container = $event->container;

        if ($container->handle() !== config('assetdrop.container')) {
            return;
        }

        $contents = $blueprint->contents();
        $section = collect($contents['tabs']['main']['sections'])
            ->search(fn ($section) => in_array('assetdrop_name', Arr::pluck($section['fields'], 'handle')));
        if ($section === false) {
            $section = count($contents['tabs']['main']['sections']);
        }

        $contents['tabs']['main']['sections'][$section] = [
            'display' => __('Assetdrop'),
            'fields' => [
                [
                    'handle' => 'assetdrop_name',
                    'field' => [
                        'display' => __('Name'),
                        'type' => 'text',
                        'visibility' => 'read_only',
                    ],
                ],
                [
                    'handle' => 'assetdrop_status',
                    'field' => [
                        'display' => __('Status'),
                        'type' => 'select',
                        'options' => [
                            'pending' => __('Pending'),
                            'processed' => __('Processed'),
                        ],
                        'default' => 'pending',
                        'visibility' => 'read_only',
                    ],
                ],
                [
                    'handle' => 'assetdrop_uploaded_at',
                    'field' => [
                        'display' => __('Uploaded At'),
                        'type' => 'date',
                        'time_enabled' => true,
                        'visibility' => 'read_only',
                    ],
                ],
                [
                    'handle' => 'assetdrop_uploaded_by',
                    'field' => [
                        'display' => __('Uploaded By'),
                        'type' => 'users',
                        'max_items' => 1,
                        'visibility' => 'read_only',
                    ],
                ],
            ],
        ];

        $blueprint->setContents($contents);
    }
}
