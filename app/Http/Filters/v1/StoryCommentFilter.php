<?php

namespace App\Http\Filters\v1;

use Illuminate\Database\Eloquent\Builder;

class StoryCommentFilter extends QueryFilter
{
    protected array $sortable = [
        'updated_at'
    ];

    public function id($value): Builder
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function parent_id($value): Builder
    {
        return $this->builder->whereIn('parent_id', explode(',', $value));
    }

    public function include($value)
    {
        $relationships = explode(',', $value);

        return $this->builder->with($relationships);
    }
}