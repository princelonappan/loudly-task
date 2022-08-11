<?php
namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use App\Service\CommonService;

class CommonServiceTest extends TestCase
{
    public function testRandomString()
    {
        $commonService = new CommonService();
        $domstring = $commonService->generateRandomString();
        $this->assertIsString($domstring);
    }
}