<?php

class authController extends Controller {
	/**
	* 字符串加密
	* @param   $string     需加密的字符
	* @param   $operation  加密或解密
	* @return  string
	*/
	function authcode($string, $operation = 'DECODE') {
		$ckey_length = 4;
		$key = md5(md5('wangdahu') );
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya . md5($keya . $keyc);
		$key_length = strlen($cryptkey);
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', 0) . substr(md5($string . $keyb), 0, 16) . $string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for ($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for ($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for ($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if ($operation == 'DECODE') {
			if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc . str_replace('=', '', base64_encode($result));
		}
	}
	
	public function set($name, $value, $expire = 3600) {
		$cookieName = $this->getName($name);
		$cookieExpire = time() + $expire;
		$cookieValue = $this->pack($value, $cookieExpire);
		$cookieValue = $this->authcode($cookieValue, 'ENCODE');
		if($cookieName && $cookieValue && $cookieExpire) {
			setcookie($cookieName, $cookieValue, $cookieExpire);
		}
	}
	
	public function get($name) {
		$cookieName = $this->getName($name);
		if(isset($_COOKIE[$cookieName])) {
			$cookieValue = $this->authcode($_COOKIE[$cookieName], 'DECODE');
			$cookieValue = $this->unpack($cookieValue);
			return isset($cookieValue[0]) ? $cookieValue[0] : null;
		}
		return null;
	}

	public function update($name, $value) {
		$cookieName = $this->getName($name);
		if(isset($_COOKIE[$cookieName])) {
			$oldCookieValue = $this->authcode($_COOKIE[$cookieName], 'ENCODE');
			$oldCookieValue = $this->unpack($oldCookieValue);
			if(isset($oldCookieValue[1]) && $oldCookieValue[1] > 0) {
				$cookieExpire = $oldCookieValue[1];

				$cookieValue = $this->pack($value, $cookieExpire);
				$cookieValue = $this->authcode($cookieValue, 'ENCODE');
				if($cookieName && $cookieValue && $cookieExpire) {
					setcookie($cookieName, $cookieValue, $cookieExpire);
					return true;
				}
			}
		}
		return false;
	}
	
	public function clear($name) {
		$cookieName = $this->getName($name);
		setcookie($cookieName);
	}

	public function getName($name) {
		return 'test_'.$name;
	}

	public function pack($data, $expire) {
		if($data == '') {
			return '';
		}

		$cookieData = array();
		$cookieData['value'] = $data;
		$cookieData['expire'] = $expire;
		return json_encode($cookieData);
	}

	public function unpack($data) {
		if($data == '') {
			return array('', 0);
		}
		$cookieData = json_decode($data, true);
		if(isset($cookieData['value']) && isset($cookieData['expire'])) {
			if(time() < $cookieData['expire']) {
				return array($cookieData['value'], $cookieData['expire']);
			}
		}
		return array('', 0);
	}



}
