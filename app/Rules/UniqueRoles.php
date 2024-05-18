<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueRoles implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $roleCounts = [
            'PRESIDENT' => 0,
            'VICE PRESIDENT INTERNAL' => 0,
            'VICE PRESIDENT EXTERNAL' => 0,
            'SECRETARY' => 0,
            'TREASURER' => 0,
            'AUDITOR' => 0,
            'PUBLIC RELATION OFFICER' => 0,
        ];
        
        foreach ($value as $item) {
            if (isset($item['role'])) {
                $role = strtoupper($item['role']);
                if (array_key_exists($role, $roleCounts)) {
                    $roleCounts[$role]++;
                }
            }
        }

        $atLeastOneRoleMissing = false;
        foreach ($roleCounts as $role => $count) {
            if ($count === 0) {
                $fail("You must have at least one $role.");
                $atLeastOneRoleMissing = true;
            } elseif ($count > 1) {
                $fail("You can only have one $role.");
            }
        }

        if (!$atLeastOneRoleMissing) {
            foreach ($roleCounts as $role => $count) {
                if ($count > 1) {
                    $fail("You can only have one $role.");
                }
            }
        }
    }
}


