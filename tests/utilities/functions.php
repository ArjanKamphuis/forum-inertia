<?php

function create(string $class, array $attributes = [], ?int $times = null): object
{
    return $class::factory($times)->create($attributes);
}

function make(string $class, array $attributes = [], ?int $times = null): object
{
    return $class::factory($times)->make($attributes);
}
