@extends('statamic::layout')
@section('title', __('statamic-assetdrop::messages.title'))

@section('content')

    <header class="flex items-center justify-between mb-6">
        <h1>{{ __('statamic-assetdrop::messages.title') }}</h1>
    </header>

    <assetdrop
        :blueprint="{{ json_encode($blueprint) }}"
        :initial-values="{{ json_encode($values) }}"
        :initial-meta="{{ json_encode($meta) }}">

@endsection