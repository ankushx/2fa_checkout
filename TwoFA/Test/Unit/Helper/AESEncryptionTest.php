<?php

namespace MiniOrange\TwoFA\Test\Unit\Helper;

use MiniOrange\TwoFA\Helper\AESEncryption;
use PHPUnit\Framework\TestCase;
class AESEncryptionTest extends TestCase
{
    public function testEncryptDataPositive()
    {
        $w_bwb = "\150\145\154\154\157\x31\x32\x33";
        $Q2W3X = "\x70\141\163\163\x77\157\x72\x64";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $this->assertIsString($wWXFU);
        $this->assertNotEquals($w_bwb, $wWXFU);
    }
    public function testEncryptDataEmptyString()
    {
        $w_bwb = '';
        $Q2W3X = "\x70\141\x73\x73\167\157\162\144";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $this->assertEquals('', $wWXFU);
    }
    public function testEncryptDataShortPassword()
    {
        $w_bwb = "\x68\145\154\x6c\157";
        $Q2W3X = "\141";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $this->assertEquals('', $wWXFU);
    }
    public function testEncryptDataNonAscii()
    {
        $w_bwb = "\150\xc3\251\154\x6c\x6f";
        $Q2W3X = "\160\x61\x73\x73\167\157\x72\144";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $this->assertIsString($wWXFU);
    }
    public function testDecryptDataPositive()
    {
        $w_bwb = "\150\145\x6c\154\157\61\x32\x33";
        $Q2W3X = "\x70\141\x73\x73\x77\x6f\x72\x64";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $V4qfz = AESEncryption::decrypt_data($wWXFU, $Q2W3X);
        $this->assertEquals($w_bwb, $V4qfz);
    }
    public function testDecryptDataEmptyString()
    {
        $w_bwb = '';
        $Q2W3X = "\x70\141\163\x73\167\157\x72\x64";
        $V4qfz = AESEncryption::decrypt_data($w_bwb, $Q2W3X);
        $this->assertEquals('', $V4qfz);
    }
    public function testDecryptDataNullString()
    {
        $Q2W3X = "\160\x61\x73\x73\x77\157\x72\x64";
        $V4qfz = AESEncryption::decrypt_data(null, $Q2W3X);
        $this->assertEquals('', $V4qfz);
    }
    public function testDecryptDataShortPassword()
    {
        $w_bwb = "\x68\x65\x6c\154\157";
        $Q2W3X = "\141";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $V4qfz = AESEncryption::decrypt_data($wWXFU, $Q2W3X);
        $this->assertEquals('', $V4qfz);
    }
    public function testDecryptDataNonAscii()
    {
        $w_bwb = "\x68\xc3\xa9\x6c\x6c\x6f";
        $Q2W3X = "\x70\141\x73\x73\x77\157\162\x64";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $V4qfz = AESEncryption::decrypt_data($wWXFU, $Q2W3X);
        $this->assertEquals($w_bwb, $V4qfz);
    }
    public function testDecryptDataWithWrongPassword()
    {
        $w_bwb = "\x68\x65\x6c\x6c\x6f\61\62\x33";
        $Q2W3X = "\160\141\163\x73\167\157\x72\144";
        $H4efK = "\x77\162\x6f\x6e\x67\x70\141\x73\163";
        $wWXFU = AESEncryption::encrypt_data($w_bwb, $Q2W3X);
        $V4qfz = AESEncryption::decrypt_data($wWXFU, $H4efK);
        $this->assertNotEquals($w_bwb, $V4qfz);
    }
}