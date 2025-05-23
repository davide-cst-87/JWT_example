<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class AdminTimeOffRequestFilter extends QueryFilter
{
    // TODO Add the name and surname sortable
    protected array $sortable = [
        'type',
        'status',
        'created_at',
    ];

    public function status($value)
    {
        if (in_array($value, ['approved', 'pending', 'rejected'])) {
            return $this->builder->where('status', $value);
        }
    }

    public function type($value): Builder
    {
        if (in_array($value, ['holiday', 'sickness', 'other'])) {
            return $this->builder->where('type', $value);
        }
    }

    public function start_date($value)
    {
        return $this->builder->whereDate('start_date', '>=', $value);
    }

    public function end_date($value)
    {
        return $this->builder->whereDate('end_date', '<=', $value);
    }

    public function date_range($value)
    {
        if (isset($value['start']) && isset($value['end'])) {
            return $this->builder->whereBetween('start_date', [$value['start'], $value['end']]);
        }
    }

    public function name($value): Builder
    {
        return $this->builder->whereHas('user', function ($query) use ($value) {
            $query->where('name', 'like', '%'.$value.'%');
        });
    }

    public function surname($value): Builder
    {
        return $this->builder->whereHas('user', function ($query) use ($value) {
            $query->where('surname', 'like', '%'.$value.'%');
        });
    }

    protected function sort($value)
    {

        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            if (strpos($sortAttribute, '-') === 0) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            if (! in_array($sortAttribute, $this->sortable)) {
                continue;
            }

            // This code below exist becasue the sorting is using the index of the enum not the alphabetical order

            if ($sortAttribute === 'status') {
                return $this->builder->orderByRaw("
                FIELD(status, 'approved','pending',  'rejected') ".($direction === 'desc' ? 'DESC' : 'ASC')
                );
            }

            if ($sortAttribute === 'type') {
                return $this->builder->orderByRaw("
                FIELD(type, 'holiday','other','sickness') ".($direction === 'desc' ? 'DESC' : 'ASC')
                );
            }

            $this->builder->orderBy($sortAttribute, $direction);
        }
    }
}
