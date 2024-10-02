<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RelationshipsRule implements ValidationRule
{
    protected array $relationships = [];
    public function __construct(array $relationships) {
        $this->relationships = $relationships;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute (string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $include = explode(',', $value);
        $stringRelationships = implode(', ', $this->relationships);
        array_walk($include, function($value) use ($fail, $stringRelationships) {
            if (!in_array($value, $this->relationships)) {
                $fail("Связь {$value} не существует. Список допустимых связей: {$stringRelationships}.");
            }
        });
    }
}
