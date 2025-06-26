<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/filemanager'], function () {
  \UniSharp\LaravelFilemanager\Lfm::routes();
});
