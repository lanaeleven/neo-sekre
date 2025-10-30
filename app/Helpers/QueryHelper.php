<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class QueryHelper
{
    /**
     * Terapkan filter dinamis pada query builder.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public static function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $column => $rule) {
            if (is_array($rule)) {
                [$operator, $requestKey, $wildcard] = array_pad($rule, 3, null);
                $value = request($requestKey);

                if (!is_null($value)) {
                    if ($operator === 'like') {
                        $pattern = match ($wildcard) {
                            'left' => '%' . $value,
                            'right' => $value . '%',
                            default => '%' . $value . '%',
                        };
                        $query->where($column, 'like', $pattern);
                    } elseif ($operator === 'date>=') {
                        $query->whereDate($column, '>=', $value);
                    } elseif ($operator === 'date<=') {
                        $query->whereDate($column, '<=', $value);
                    } else {
                        $query->where($column, $operator, $value);
                    }
                }
            } else {
                $value = request($rule);
                if (!is_null($value)) {
                    $query->where($column, '=', $value);
                }
            }
        }

        return $query;
    }
}
