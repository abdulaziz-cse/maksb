<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait SearchableTrait
{
    protected function scopeSort(Builder $query, $sort_by, $sort_type = 'asc'): Builder
    {
        if (!$sort_by) {
            return $query;
        }

        return $query->when(
            str_contains($sort_by, '.'),

            function (Builder $query) use ($sort_by, $sort_type) {
                $this->sortByRelatedProperty($query, $sort_by, $sort_type);
            },

            function (Builder $query) use ($sort_by, $sort_type) {
                $query->orderBy($sort_by, $sort_type);
            }
        );
    }

    private function sortByRelatedProperty($query, $sort_by, $sort_type): void
    {
        [$relation_name, $relation_attribute] = explode('.', $sort_by);
        $related_model = $query->getRelation($relation_name)->getRelated();
        $related_model_relation = $query->getRelation($relation_name);
        $foreign_key = $related_model_relation->getForeignKeyName();
        $model = $query->getModel();
        $query->select($model->getTable() . '.*');
        $query->join($related_model->getTable() . ' as t1', $model->getTable() . '.' . $foreign_key, '=', 't1.' . $model->getKeyName())
            ->orderBy('t1.' . $relation_attribute, $sort_type);
    }
}
