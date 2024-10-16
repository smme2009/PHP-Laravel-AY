<?php

namespace App\Http\Service;

use App\Contracts\Check as IFCheck;

class Order
{
    // 訊息
    private string $message = '';

    // 檢查欄位列表
    private array $needCheckFieldList = [
        'name' => ['NameIsEnglish', 'NameWordFirstIsUpper'],
        'price' => ['PriceLimit'],
        'currency' => ['CurrencyType'],
    ];

    /**
     * 轉換資料
     * 
     * @param array $orderData 訂單資料
     * 
     * @return bool|array
     */
    public function converData(array $orderData): bool|array
    {
        // 驗證需驗證資料
        foreach ($this->needCheckFieldList as $Field => $checkList) {
            $isPass = $this->checkFiled($orderData[$Field], $checkList);

            if ($isPass === false) {
                return false;
            }
        }

        // 轉換貨幣
        if ($orderData['currency'] === 'USD') {
            $orderData['price'] *= 31;
            $orderData['currency'] = 'TWD';
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
     * 驗證欄位
     * 
     * @param mixed $value 值
     * @param array $checkList 驗證列表
     * 
     * @return bool 是否通過
     */
    private function checkFiled(mixed $value, array $checkList): bool
    {
        foreach ($checkList as $name) {
            $checker = app()->make(__NAMESPACE__ . '\Check\\' . $name);
            $isPass = $this->check($checker, $value);

            if ($isPass === false) {
                return false;
            }
        }

        return true;
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
