<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;

class OrderTest extends TestCase
{
    // 網址
    private string $url = '/api/orders';

    // 訂單資料(正確)  
    private array $orderData = [
        'id' => 'A0000001',
        'name' => 'Melody Holiday Inn',
        'address' => [
            'city' => 'taipei-city',
            'district' => 'da-an-district',
            'street' => 'fuxing-south-road',
        ],
        'price' => '2000',
        'currency' => 'TWD',
    ];

    /**
     * 測試(成功)
     */
    public function testSuccess(): void
    {
        $this->setResponse(200);
    }

    /**
     * 測試(名字有非英文)
     */
    public function testNameIsNotEnglish(): void
    {
        $this->orderData['name'] .= '中文';
        $this->setResponse(400);
    }

    /**
     * 測試(名字字節首字非大寫)
     */
    public function testNameWordFirstIsNotUpper(): void
    {
        $this->orderData['name'] = 'Melody holiday Inn';
        $this->setResponse(400);
    }

    /**
     * 測試(金額超過2000)
     * 
     * @return void
     */
    public function testPriceExceed(): void
    {
        $this->orderData['price'] = 2001;
        $this->setResponse(400);
    }

    /**
     * 測試(幣別錯誤)
     * 
     * @return void
     */
    public function testCurrencyTypeError(): void
    {
        $this->orderData['currency'] = 'JPY';
        $this->setResponse(400);
    }

    /**
     * 設定Response
     * 
     * @param $httpCode 期望獲得的HTTP Code 
     * 
     * @return void
     */
    private function setResponse(int $httpCode): void
    {
        $response = $this->post($this->url, $this->orderData);
        $response->assertStatus($httpCode);
    }
}
