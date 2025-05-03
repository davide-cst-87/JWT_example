<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TimeOffRequestFilter extends QueryFilter
{
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
}
