<?php

namespace App\Http\Filters;

class TimeOffRequestFilter extends QueryFilter
{
    public function status($value)
    {
        if (in_array($value, ['approved', 'pending', 'rejected'])) {
            return $this->builder->where('status', $value);
        }
    }
}
