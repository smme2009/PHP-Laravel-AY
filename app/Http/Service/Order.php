<?php

namespace App\Http\Service;

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
        // 檢查名稱是否為英文
        $isPass = $this->checkNameIsEnglish($orderData['name']);
        if ($isPass === false) {
            $this->message = 'Name contains non-English characters';
            return false;
        }

        // 檢查名稱單字的首字是否為大寫
        $isPass = $this->checkNameWordFirstIsUpper($orderData['name']);
        if ($isPass === false) {
            $this->message = 'Name is not capitalized';
            return false;
        }

        // 檢查金額是否超過限制
        $isPass = $this->checkPriceLimit($orderData['price']);
        if ($isPass === false) {
            $this->message = 'Price is over 2000';
            return false;
        }

        // 檢查貨幣類型
        $isPass = $this->checkCurrencyType($orderData['currency']);
        if ($isPass === false) {
            $this->message = 'Currency format is wrong';
            return false;
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
        $message = $this->message;

        return $message;
    }

    /**
     * 檢查名稱是否為英文
     * 
     * @param string $name 名稱
     * 
     * @return bool 是否通過檢查
     */
    private function checkNameIsEnglish(string $name): bool
    {
        $isPass = preg_match('/^[a-zA-Z\x20]+$/', $name);

        return $isPass;
    }

    /**
     * 檢查名稱單字的首字是否為大寫
     * 
     * @param string $name 名稱
     * 
     * @return bool 是否通過檢查
     */
    private function checkNameWordFirstIsUpper(string $name): bool
    {
        $wordList = explode(' ', $name);

        foreach ($wordList as $word) {
            if (ctype_upper($word[0]) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * 檢查金額是否超過限制
     * 
     * @param int $price 金額
     * 
     * @return bool 是否通過檢查
     */
    private function checkPriceLimit(int $price): bool
    {
        $isPass = ($price <= 2000);

        return $isPass;
    }

    /**
     * 檢查貨幣類型
     * 
     * @param string $currency 貨幣類型
     * 
     * @return bool 是否通過檢查
     */
    private function checkCurrencyType(string $currency): bool
    {
        $type = [
            'TWD',
            'USD',
        ];

        $isPass = in_array($currency, $type);

        return $isPass;
    }
}
