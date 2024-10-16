<?php

namespace App\Http\Service;

use App\Contracts\Check as IFCheck;
use App\Http\Service\Check\NameIsEnglish;
use App\Http\Service\Check\NameWordFirstIsUpper;
use App\Http\Service\Check\PriceLimit;
use App\Http\Service\Check\CurrencyType;

class Order
{
    // 訊息
    private string $message = '';

    /**
     * 轉換資料
     * 
     * @param array $orderData 訂單資料
     * 
     * @return bool|array
     */
    public function converData(array $orderData): bool|array
    {
        // 驗證名稱是否為英文
        if ($this->check(new NameIsEnglish, $orderData['name']) === false) {
            return false;
        }

        // 驗證名稱各字節首字是否為大寫
        if ($this->check(new NameWordFirstIsUpper, $orderData['name']) === false) {
            return false;
        }

        // 驗證幣別
        if ($this->check(new CurrencyType, $orderData['currency']) === false) {
            return false;
        }

        // 轉換貨幣
        // 把USD轉為TWD再驗證總額
        if ($orderData['currency'] === 'USD') {
            $orderData['price'] *= 31;
            $orderData['currency'] = 'TWD';
        }

        // 驗證總額
        if ($this->check(new PriceLimit, $orderData['price']) === false) {
            return false;
        }

        return $orderData;
    }

    /**
     * 取得訊息
     * 
     * @return string 訊息
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * 驗證
     * 
     * @param IFCheck $checker 驗證器
     * @param mixed $value 值
     * 
     * @return bool 是否通過
     */
    private function check(IFCheck $checker, mixed $value): bool
    {
        $isPass = $checker->check($value);

        if ($isPass === false) {
            $this->message = $checker->getErrorMessage();
        }

        return $isPass;
    }
}
