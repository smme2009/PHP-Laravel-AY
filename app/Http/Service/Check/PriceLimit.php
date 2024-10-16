<?php

namespace App\Http\Service\Check;

use App\Contracts\Check as IFCheck;

class PriceLimit implements IFCheck
{
    /**
     * 驗證
     * 
     * @param mixed $value 值
     * 
     * @return bool 是否通過
     */
    public function check(mixed $value): bool
    {
        $isPass = ($value <= 2000);
        return $isPass;
    }

    /**
     * 取得錯誤訊息
     * 
     * @return string 錯誤訊息
     */
    public function getErrorMessage(): string
    {
        $message = 'Price is over 2000';
        return $message;
    }
}
