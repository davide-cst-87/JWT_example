<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

abstract class QueryFilter
{
    protected $builder;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            } else {
                throw ValidationException::withMessages([
                    $key => ["Unknown filter: $key"],
                ]);
            }
        }

        return $this->builder;
    }
}
