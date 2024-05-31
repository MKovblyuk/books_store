<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueExceptCurrent implements ValidationRule
{
    private string $current_value;
    private string $table;
    private string $column;

    public function __construct(string $table, string $column ,string $current_value,)
    {
        $this->current_value = $current_value;
        $this->table = $table;
        $this->column = $column;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rowsCount = DB::table($this->table)->where($this->column, $value)->count();

        if ($value !== $this->current_value && $rowsCount > 0) {
            $fail('The :attribute already exists');
        }
        if ($value === $this->current_value && $rowsCount > 1) {
            $fail('The :attribute already exists');
        }
    }
}
