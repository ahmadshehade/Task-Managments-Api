<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\Rule;


class ValidDueDate implements Rule
{
    /**
     * Summary of passes
     * @param mixed $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value){
      return  Carbon::parse($value)->greaterThanOrEqualTo(now());
    }
    /**
     * Summary of message
     * @return string
     */
    public function message(){

           return 'The due date must be a date after  to now.';
    }

}
