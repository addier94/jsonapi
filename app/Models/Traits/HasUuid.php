<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
  public function getIncrementing()
  {
    return false;
  }

  public function getKeyType()
  {
    return 'string';
  }

  protected static function bootHasUuid() // magit methods for booted
  {
    static::creating(function ($model) {
      // $model->id = Str::uuid()->toString();
      $model->{$model->getKeyName()} = Str::uuid()->toString();
    });
  }
}
