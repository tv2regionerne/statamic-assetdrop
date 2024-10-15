<?php

namespace Tv2regionerne\StatamicAssetdrop\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Statamic\Contracts\Assets\Asset;
use Tv2regionerne\StatamicAssetdrop\Actions\ProcessUpload as ProcessUploadAction;

class ProcessUpload implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Asset $asset,
    ) {}

    public function handle(): void
    {
        app(ProcessUploadAction::class)->handle($this->asset);
    }
}
