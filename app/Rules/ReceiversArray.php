<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class ReceiversArray implements Rule
{
    /**
     * Service for working with phones
     *
     * @var PhoneNumberUtil
     */
    public $phoneUtil;

    /**
     * Number failed validation
     *
     * @var string
     */
    public $failedPhoneNumber = '';

    /**
     * ReceiversArray constructor.
     * @param PhoneNumberUtil $phoneUtil
     */
    public function __construct(PhoneNumberUtil $phoneUtil)
    {
        $this->phoneUtil = $phoneUtil;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value):bool
    {
        //проверить массив на уникальность значений
        if(!($value === array_unique($value))){
            $this->message = 'The field must contain only unique values';
            return false;
        }
        //проверить номера
        foreach ($value as $p){
            try{
                $phoneNumber = $this->phoneUtil->parse($p);
                if(!$this->phoneUtil->isValidNumber($phoneNumber)){
                    $this->failedPhoneNumber = $p;
                    return false;
                }
            }catch (NumberParseException $e){
                $this->failedPhoneNumber = $p;
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
        return "Field contain incorrect value: {$this->failedPhoneNumber}.";
    }
}