<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function booted(): void
    {
        static::creating(function (Model $model) {
            $sourceAttribute = $model->slugSource ?? 'name';
            $targetAttribute = $model->slugTarget ?? 'slug';

            if (empty($model->{$targetAttribute})) {
                $slug = static::makeSlug($model->{$sourceAttribute});
                $originalSlug = $slug;
                $i = 1;

                while ($model->newQuery()->where($targetAttribute, $slug)->exists()) {
                    $slug = $originalSlug . '-' . $i++;
                }

                $model->{$targetAttribute} = $slug;
            }
        });
    }

    private static function makeSlug($string = null, $separator = "-")
    {
        if ($string === null)
            return "";

        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");
        $string = preg_replace("/[^\p{L}0-9_\s-]/u", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }
}