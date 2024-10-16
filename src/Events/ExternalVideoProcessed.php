<?php

namespace Tv2regionerne\StatamicAssetdrop\Events;

use Statamic\Events\Event;

class ExternalVideoProcessed extends Event
{
    public function __construct(
        public $asset,
    ) {}
}
