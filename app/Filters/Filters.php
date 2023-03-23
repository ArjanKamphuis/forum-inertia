<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    protected Request $request;
    protected Builder $builder;

    protected array $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $this->$filter($value);
        }

        return $this->builder;
    }

    protected function getFilters(): array
    {
        $acceptedFilters = array_intersect($this->request->keys(), $this->filters);
        $existingFilters = array_filter($acceptedFilters, fn($filter) => method_exists($this, $filter));
        return $this->request->only($existingFilters);
    }
}
