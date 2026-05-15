<?php

namespace App\Libraries;

use Illuminate\Database\Eloquent\Model;
use Stichoza\GoogleTranslate\GoogleTranslate as Translator;

class GoogleTranslate
{
    protected array $locales = [
        'id',
        'zh',
        'fr',
    ];

    public function translateModel(
        Model $model,
        bool $force = false,
    ): void {
        if (! property_exists($model, 'translatable')) {
            return;
        }

        $updates = [];

        foreach ($model->translatable as $field) {
            $value = $model->{$field};

            if (blank($value)) {
                continue;
            }

            if (
                ! $force &&
                method_exists($model, 'wasChanged') &&
                ! $model->wasChanged($field) &&
                ! $model->wasRecentlyCreated
            ) {
                continue;
            }

            foreach ($this->locales as $locale) {
                $column = "{$field}_{$locale}";

                $updates[$column] = (new Translator($locale))
                    ->translate($value);
            }
        }

        if (! empty($updates)) {
            $model->update($updates);
        }
    }
}
