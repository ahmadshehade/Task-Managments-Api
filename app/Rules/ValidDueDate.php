<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\Rule;


class ValidDueDate implements Rule
{
    public function passes($attribute, $value){
      return  Carbon::parse($value)->greaterThanOrEqualTo(now());
    }
    public function message(){

           return 'The due date must be a date after  to now.';
    }

}
