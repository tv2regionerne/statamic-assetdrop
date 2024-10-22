<?php

namespace Tv2regionerne\StatamicAssetdrop\Actions\CP;

use Statamic\Actions\Action;
use Statamic\Contracts\Assets\Asset;
use Tv2regionerne\StatamicAssetdrop\Actions\ProcessUpload as ProcessUploadAction;

class ProcessUpload extends Action
{
    protected static $handle = 'assetdrop_process_upload';

    public static function title()
    {
        return __('Process');
    }

    public function visibleTo($item)
    {
        return $item instanceof Asset && $item->container()->handle() === config('assetdrop.container');
    }

    public function authorize($user, $item)
    {
        return $user->can('access assetdrop');
    }

    public function run($items, $values)
    {
        $asset = $items->first();

        return app(ProcessUploadAction::class)->handle($asset);
    }
}
