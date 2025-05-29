<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

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
        } else {
            throw ValidationException::withMessages([
                'status' => ['Invalid status. Allowed values: approved, pending, rejected.'],
            ]);
        }
    }

    public function type($value): Builder
    {
        if (in_array($value, ['holiday', 'sickness', 'other'])) {
            return $this->builder->where('type', $value);
        } else {
            throw ValidationException::withMessages([
                'type' => ['Invalid type. Allowed values: holiday, sickness, other'],
            ]);
        }
    }

    public function start_date($value)
    {
        if (! $this->isValidDate($value)) {
            throw ValidationException::withMessages([
                'start_date' => ['Invalid start_date. Must be a valid date (YYYY-MM-DD).'],
            ]);
        }

        return $this->builder->whereDate('start_date', '>=', $value);
    }

    public function end_date($value)
    {
        if (! $this->isValidDate($value)) {
            throw ValidationException::withMessages([
                'end_date' => ['Invalid end_date. Must be a valid date (YYYY-MM-DD).'],
            ]);
        }

        return $this->builder->whereDate('end_date', '<=', $value);
    }

    public function date_range($value)
    {
        if (
            ! is_array($value) ||
            ! isset($value['start'], $value['end']) ||
            ! $this->isValidDate($value['start']) ||
            ! $this->isValidDate($value['end'])
        ) {
            throw ValidationException::withMessages([
                'date_range' => ['Invalid date_range. Must include valid start and end dates.'],
            ]);
        }

        return $this->builder->whereBetween('start_date', [$value['start'], $value['end']]);
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

    protected function isValidDate($value): bool
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);

        // This last bit is checking if the date created from the string has the right format to avoid sample2025-16-45
        return $date && $date->format('Y-m-d') === $value;
    }
}
