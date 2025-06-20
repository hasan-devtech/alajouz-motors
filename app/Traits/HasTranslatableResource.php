<?php

namespace App\Traits;

trait HasTranslatableResource
{
    public static function getTranslationPath(): string
    {
        return 'filament.resources.' . str(class_basename(static::$model))->kebab();
    }

    public static function getModelLabel(): string
    {
        return __(static::getTranslationPath() . '.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __(static::getTranslationPath() . '.pluralModelLabel');
    }

    public static function getNavigationLabel(): string
    {
        return __(static::getTranslationPath() . '.navigationLabel');
    }
}