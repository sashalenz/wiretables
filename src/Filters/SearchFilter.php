<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SearchFilter
{
    public function __construct(
        private readonly ?string $value,
        private readonly bool $strict = false
    ) {
    }

    public function __invoke(Builder $query): Builder
    {
        return $query->when($this->value, function (Builder $query) {
            return $query->where(function (Builder $query) {
                $model = $query->getModel();
                $table = $model->getTable();

                if (method_exists($model, 'getSearchable')) {
                    $fillable = $model->getSearchable();
                }

                if (! isset($fillable) || ! count($fillable)) {
                    $fillable = $query->getModel()->getFillable();
                }

                foreach ($fillable as $field) {
                    $query->orWhere(function (Builder $query) use ($table, $field) {
                        if ($this->strict) {
                            $query->where($table . '.' . $field, 'LIKE', $this->value);
                        } else {
                            foreach (explode(' ', $this->value) as $word) {
                                $query->whereRaw('LOWER('.$table . '.' . $field.') LIKE ' . Str::of($word)->lower()->prepend('"%')->append('%"')->toString());
                            }
                        }
                    });
                }

                if (method_exists($model, 'getSearchableRelations')) {
                    foreach ($model->getSearchableRelations() as $relation) {
                        $query->orWhereHas(
                            $relation,
                            fn (Builder $query) => $query->tap(new self($this->value, $this->strict))
                        );
                    }
                }

                return $query->orWhere(function (Builder $query) use ($table, $model) {
                    foreach (explode(',', $this->value) as $id) {
                        if (is_numeric($id) && $model->getIncrementing() === true) {
                            $query->orWhere($table . '.' . $model->getKeyName(), $id);
                        }
                    }
                });
            });
        });
    }
}
