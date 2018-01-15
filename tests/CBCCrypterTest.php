<?php


use Naski\CBCCrypter\CBCCrypter;
use PHPUnit\Framework\TestCase;

//require_once 'boot.php';

class CBCCrypterTest extends TestCase
{
    public function testIt()
	{
		$input = 'allez on crypte';
		$crypter = new CBCCrypter('tata', 'toto');
		$crypted = $crypter->crypt($input);
		$this->assertNotEquals($crypted, $input);
		$decrypted = $crypter->decrypt($crypted);
		$this->assertEquals($decrypted, $input);
	}


}
