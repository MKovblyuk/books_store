<?php

namespace Tests\Unit;

use App\Rules\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_phone_number_validation(): void
    {
        $phoneNumberRule = new PhoneNumber();

        $this->assertTrue($phoneNumberRule->isPhoneNumber('0975265277'));
        $this->assertTrue($phoneNumberRule->isPhoneNumber('0000065272'));
        $this->assertFalse($phoneNumberRule->isPhoneNumber('asdsa'));
        $this->assertFalse($phoneNumberRule->isPhoneNumber('09752652771'));
    }
}
