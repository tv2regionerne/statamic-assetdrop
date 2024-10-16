<?php

namespace Tv2regionerne\StatamicAssetdrop\Events;

use Statamic\Events\Event;

class ExternalDocumentProcessed extends Event
{
    public function __construct(
        public $asset,
    ) {}
}
