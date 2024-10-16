<?php

namespace Tv2regionerne\StatamicAssetdrop\Events;

use Statamic\Events\Event;

class StatamicImageProcessed extends Event
{
    public function __construct(
        public $asset,
        public $newAsset,
    ) {}
}
