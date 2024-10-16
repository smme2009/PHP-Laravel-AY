<?php

namespace App\Http\Service\Check;

use App\Contracts\Check as IFCheck;

// 名稱是否為英文
class NameIsEnglish implements IFCheck
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
        $isPass = preg_match('/^[a-zA-Z\x20]+$/', $value);
        return $isPass;
    }

    /**
     * 取得錯誤訊息
     * 
     * @return string 錯誤訊息
     */
    public function getErrorMessage(): string
    {
        $message = 'Name contains non-English characters';
        return $message;
    }
}
