<?php

namespace App\Http\Filters\v1;

use Illuminate\Database\Eloquent\Builder;

class StoryFilter extends QueryFilter
{
    protected array $sortable = [
        'title',
        'position'
    ];

    public function id($value): Builder
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function include($value)
    {
        return $this->builder->with($value);
    }

    public function is_published($value)
    {
        if (strtolower($value) === 'true') {
            $value = 1;
        } elseif (strtolower($value) === 'false') {
            $value = 0;
        }
        return $this->builder->where('is_published', $value);
    }
}