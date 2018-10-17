<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MessengersArray implements Rule
{
    /**
     * Error message
     *
     * @var string
     */
    private $message = '';
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value):bool
    {
        //проверить что это массив уникальных значений
        if(!is_array($value)){
            $this->message = 'The field must be an array';
            return false;
        }
        //проверить массив на уникальность значений
        if(!($value === array_unique($value))){
            $this->message = 'The field must contain only unique values';
            return false;
        }
        //проверка на наличие неподдерживаемых элементов
        foreach($value as $m){
            if(array_search($m, config('senderman.supportedMessengers')) === false){
                $this->message = "The field contains unsupported value: {$m}";
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message():string
    {
        return $this->message;
    }
}