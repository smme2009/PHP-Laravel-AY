<?php

namespace App\Http\Service\Check;

use App\Contracts\Check as IFCheck;

// 幣別是否正確
class CurrencyType implements IFCheck
{
    // 類型
    private array $type = [
        'TWD',
        'USD',
    ];

    /**
     * 驗證
     * 
     * @param mixed $value 值
     * 
     * @return bool 是否通過
     */
    public function check(mixed $value): bool
    {
        $isPass = in_array($value, $this->type);
        return $isPass;
    }

    /**
     * 取得錯誤訊息
     * 
     * @return string 錯誤訊息
     */
    public function getErrorMessage(): string
    {
        $message = 'Currency format is wrong';
        return $message;
    }
}
