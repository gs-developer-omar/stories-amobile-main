<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExcludeRepliesAndParentComment implements ValidationRule
{
    protected array $relationships = [];
    public function __construct(array $relationships) {
        $this->relationships = $relationships;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $include = explode(',', $value);
        if (in_array('parentComment', $include) && in_array('replies', $include)) {
            $fail("Связи parentComment и replies не не должны использоваться вместе.");
        }
    }
}
