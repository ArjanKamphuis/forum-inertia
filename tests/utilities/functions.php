<?php

function create(string $class, array $attributes = []): object
{
    return $class::factory()->create($attributes);
}

function make(string $class, array $attributes = []): object
{
    return $class::factory()->make($attributes);
}
