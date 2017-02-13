<?php

use Naski\CBCCrypter\CBCCrypter;

require_once 'boot.php';

class CBCCrypterTest extends PHPUnit_Framework_TestCase
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
