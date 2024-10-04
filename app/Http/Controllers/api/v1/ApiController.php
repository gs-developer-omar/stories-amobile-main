<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

abstract class ApiController extends Controller
{
    protected function loadedRelationships(): array
    {
        $include = request()->get('include');
        if (!isset($include)) {
            return [];
        }
        return explode(',', $include);
    }

    protected function validRelationships(array $modelRelationships): array
    {
        return array_intersect($this->loadedRelationships(), $modelRelationships);
    }
}
