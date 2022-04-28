<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    private ?string $value = null;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function __invoke(Builder $query): Builder
    {
        return $query->when($this->value, function (Builder $query) {
            return $query->where(function (Builder $query) {
                $searchable = $query->getModel()->getSearchable();
                $relations = $query->getModel()->getSearchableRelations();
                $table = $query->getModel()->getTable();
                $key = $query->getModel()->getKeyName();

                foreach ($searchable as $field) {
                    $query->orWhere(function (Builder $query) use ($table, $field) {
                        foreach (explode(' ', $this->value) as $word) {
                            $query->where($table.'.'.$field, 'LIKE', '%'.$word.'%');
                        }
                    });
                }

                foreach ($relations as $relation) {
                    $query->orWhereHas($relation, function (Builder $query) {
                        return $query->tap(new self($this->value));
                    });
                }

                return $query->orWhere(function (Builder $query) use ($table, $key) {
                    foreach (explode(',', $this->value) as $id) {
                        if (is_numeric($id)) {
                            $query->orWhere($table . '.' . $key, $id);
                        }
                    }
                });
            });
        });
    }
}
