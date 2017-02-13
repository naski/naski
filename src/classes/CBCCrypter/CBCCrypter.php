<?php

namespace Naski\CBCCrypter;

class CBCCrypter {

	protected $_key;
	protected $_iv;

	public function __construct($key, $iv) {
		$this->_key = $key;
		$this->_iv = $iv;
	}

	private function aes128_cbc_decrypt($data) {
		$key = $this->_key;
		$iv = $this->_iv;

		if (!$data) {
			throw new \Exception("Error during aes128_cbc_decrypt", 1);
		}

		if (16 !== strlen($key)) $key = hash('MD5', $key, true);
		if (16 !== strlen($iv)) $iv = hash('MD5', $iv, true);
        $data = openssl_decrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
	    return $data;
	}

	private function aes128_cbc_encrypt($data) {
		$key = $this->_key;
		$iv = $this->_iv;

		if (16 !== strlen($key)) $key = hash('MD5', $key, true);
		if (16 !== strlen($iv)) $iv = hash('MD5', $iv, true);
        return openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
	}

	/**
	 * Crypte une chaine passée en paramettre
	 * @param  Les données brut
	 * @return la claine cryptée et encodée en base64
	 */
	public function crypt($data) {
		$data = $this->aes128_cbc_encrypt($data);
		$data = base64_encode($data);
		return $data;
	}

	/**
	 * Décrypte une chaine passée en parametre
	 * @param  La chaine cryptée et encodée en base64
	 * @return [type]       [description]
	 */
	public function decrypt($data) {
		$data = base64_decode($data);
		$data = $this->aes128_cbc_decrypt($data);
		if (!$data) {
			throw new \Exception("Error during mcrypt_decrypt", 1);
		}
		if (!preg_match('//u', $data)) {
			throw new \Exception("Data decrypted inst a valid ASCII string", 1);
		}
		return $data;
	}

}
