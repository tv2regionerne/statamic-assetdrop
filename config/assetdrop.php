<?php

return [

    'container' => env('ASSETDROP_CONTAINER', 'assetdrop'),

    'remove_processed' => env('ASSETDROP_REMOVE_PROCESSED', true),

    'image' => [
        'enabled' => env('ASSETDROP_IMAGE_ENABLE', true),
        'statamic' => [
            'enabled' => env('ASSETDROP_IMAGE_STATAMIC_ENABLE', true),
            'container' => env('ASSETDROP_IMAGE_STATAMIC_CONTAINER', 's3'),
            'path' => env('ASSETDROP_IMAGE_STATAMIC_PATH', 'Assetdrop {{ assetdrop_uploaded_at | format="dmy" }} {{ assetdrop_name }} {{ assetdrop_uploaded_by:initials }}.{{ extension }}'),
            'tags' => env('ASSETDROP_IMAGE_STATAMIC_TAGS', 'assetdrop'),
        ],
        'external' => [
            'enabled' => env('ASSETDROP_IMAGE_EXTERNAL_ENABLE', true),
            'disk' => env('ASSETDROP_IMAGE_EXTERNAL_DISK', 'ftp'),
            'path' => env('ASSETDROP_IMAGE_EXTERNAL_PATH', '{{ assetdrop_uploaded_at | format="dmy" }}-{{ assetdrop_uploaded_by:initials }}-{{ assetdrop_name }}.{{ extension }}'),
        ],
    ],

    'video' => [
        'enabled' => env('ASSETDROP_VIDEO_ENABLE', true),
        'statamic' => [
            'enabled' => env('ASSETDROP_VIDEO_STATAMIC_ENABLE', true),
            'container' => env('ASSETDROP_VIDEO_STATAMIC_CONTAINER', 's3'),
            'path' => env('ASSETDROP_VIDEO_STATAMIC_PATH', '{{ assetdrop_uploaded_at | format="dmy" }} Assetdrop {{ assetdrop_uploaded_by:initials }}-{{ assetdrop_name }}.{{ extension }}'),
            'tags' => env('ASSETDROP_IMAGE_STATAMIC_TAGS', 'assetdrop'),
        ],
        'external' => [
            'enabled' => env('ASSETDROP_VIDEO_EXTERNAL_ENABLE', false),
            'disk' => env('ASSETDROP_VIDEO_EXTERNAL_DISK', 'ftp'),
            'path' => env('ASSETDROP_VIDEO_EXTERNAL_PATH', '{{ assetdrop_uploaded_at | format="dmy" }}-{{ assetdrop_uploaded_by:initials }}-{{ assetdrop_name }}.{{ extension }}'),
        ],
    ],

    'document' => [
        'enabled' => env('ASSETDROP_DOCUMENT_ENABLE', true),
        'statamic' => [
            'enabled' => env('ASSETDROP_DOCUMENT_STATAMIC_ENABLE', true),
            'container' => env('ASSETDROP_DOCUMENT_STATAMIC_CONTAINER', 's3'),
            'path' => env('ASSETDROP_DOCUMENT_STATAMIC_PATH', 'Assetdrop {{ assetdrop_uploaded_at | format="dmy" }} {{ assetdrop_name }} {{ assetdrop_uploaded_by:initials }}.{{ extension }}'),
            'tags' => env('ASSETDROP_DOCUMENT_STATAMIC_TAGS', 'assetdrop'),
        ],
        'external' => [
            'enabled' => env('ASSETDROP_DOCUMENT_EXTERNAL_ENABLE', false),
            'disk' => env('ASSETDROP_DOCUMENT_EXTERNAL_DISK', 'ftp'),
            'path' => env('ASSETDROP_DOCUMENT_EXTERNAL_PATH', '{{ assetdrop_uploaded_at | format="dmy" }}-{{ assetdrop_uploaded_by:initials }}-{{ assetdrop_name }}.{{ extension }}'),
        ],
    ],

];
