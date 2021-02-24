<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

JsonApi::register('v1')->routes(function ($api) {
  $api->resource('articles')->only('create', 'update')->middleware('auth');
  $api->resource('articles')->except('create', 'update');
});
