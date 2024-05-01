<?php

namespace App\Services\V2\Settings;

use App\Models\V2\Settings\PredefinedValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PredefinedValueService
{
    public function getOne($id): Builder|array|Collection|Model|null
    {
        $predefined = PredefinedValue::with('group')->find($id);
        if (!$predefined) {
            return null;
        }

        return $predefined;
    }

    public function getBySlug(string $slug): ?PredefinedValue
    {
        return PredefinedValue::where('slug', $slug)->first();
    }
}