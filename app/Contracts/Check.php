<?php

namespace App\Contracts;

interface Check
{
    /**
     * 檢查
     * 
     * @param string|int $value 值
     * 
     * @return bool 是否通過
     */
    public function check(mixed $value): bool;


    /**
     * 取得錯誤信息
     * 
     * @return string 錯誤信息
     */
    public function getErrorMessage(): string;
}