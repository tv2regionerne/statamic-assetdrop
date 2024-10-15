<?php

namespace Tv2regionerne\StatamicAssetdrop\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\Facades\Asset;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Blueprint;
use Statamic\Http\Controllers\CP\CpController;
use Tv2regionerne\StatamicAssetdrop\Jobs\ProcessUpload;

class AssetdropController extends CpController
{
    public function index(Request $request)
    {
        $this->authorize('access assetdrop', [], __('You are not authorized to access Assetdrop.'));

        $container = AssetContainer::find(config('assetdrop.container'));
        if (! $container) {
            throw new \Exception('Assetdrop container not found');
        }

        $blueprint = Blueprint::makeFromFields([
            'name' => [
                'type' => 'text',
                'validate' => 'required',
            ],
            'assets' => [
                'type' => 'large_assets',
                'container' => $container->handle(),
            ],
        ]);

        $fields = $blueprint
            ->fields()
            ->preProcess();

        return view('statamic-assetdrop::index', [
            'blueprint' => $blueprint->toPublishArray(),
            'values' => $fields->values(),
            'meta' => $fields->meta(),
        ]);
    }

    public function queue(Request $request)
    {
        $this->authorize('access assetdrop', [], __('You are not authorized to access Assetdrop.'));

        $asset = Asset::find($request->id);

        ProcessUpload::dispatch($asset);

        return response()->json();
    }
}
