<?php

namespace App\Rules;

use Carbon\Carbon;
use App\TokenReset;
use Illuminate\Contracts\Validation\Rule;

class ExistCode implements Rule
{
    public $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passreset = TokenReset::where('mobile', $this->data['mobile'])->where('code', $value)->first();

        if($passreset){
            return true;
        }
        return false;
        // dd($attribute,$value,$this->data);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد وارد شده معتبر نمیباشد لطفا دقایقی دیگر مجدد تلاش کنید';
    }
}
