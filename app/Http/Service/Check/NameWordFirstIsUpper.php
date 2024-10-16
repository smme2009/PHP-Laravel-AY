<?php

namespace App\Http\Service\Check;

use App\Contracts\Check as IFCheck;

class NameWordFirstIsUpper implements IFCheck
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
        $wordList = explode(' ', $value);

        foreach ($wordList as $word) {
            if (ctype_upper($word[0]) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * 取得錯誤訊息
     * 
     * @return string 錯誤訊息
     */
    public function getErrorMessage(): string
    {
        $message = 'Name is not capitalized';
        return $message;
    }
}
