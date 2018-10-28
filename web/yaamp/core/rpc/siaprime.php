<?php

class SiaPrimeRPC
{
	private $password;

	private $proto;
	private $host;
	private $port;

	// Information and debugging
	public $status;
	public $error;
	public $raw_response;
	public $response;

	private $id = 0;

	function __construct($host='localhost', $port=4280, $password='')
	{
		$this->proto    = 'http';
		$this->host     = $host;
		$this->port     = $port;
		$this->password = $password;
	}

	function rpcrequest($curl)
	{
		$options = array(
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_HTTPHEADER     => array(
				'Content-Type: application/json',
				'User-Agent: SiaPrime-Agent',
			),
		);
		curl_setopt_array($curl, $options);
		if (!empty($this->password)) {
			curl_setopt($curl, CURLOPT_USERPWD, $this->password);
		}

		$this->raw_response = curl_exec($curl);
		$this->response = json_decode($this->raw_response, TRUE);

		// If the status is not 200, something is wrong
		$this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		// If there was no error, this will be an empty string
		$curl_error = curl_error($curl);

		curl_close($curl);

		if (!empty($curl_error)) {
			$this->error = $curl_error;
		}

		if ($this->status != 200) {
			// If didn't return a nice error message, we need to make our own
			switch ($this->status) {
				case 400:
					$this->error = 'HTTP_BAD_REQUEST';
					break;
				case 401:
					$this->error = 'HTTP_UNAUTHORIZED';
					break;
				case 403:
					$this->error = 'HTTP_FORBIDDEN';
					break;
				case 404:
					$this->error = 'HTTP_NOT_FOUND';
					break;
				case 405:
					$this->error = 'HTTP_METHOD_NOT_ALLOWED';
			}
		}

		return $this->response;
	}

	function rpcget($url, $params=array())
	{
		$url = "{$this->proto}://{$this->host}:{$this->port}{$url}";
		if (!empty($params)) {
			$url = "?ts=".time();
			foreach ($params as $key => $val) {
				$url .= '&'.urlencode($key).'='.urlencode($val);
			}
		}
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, false);
		return $this->rpcrequest($curl);
	}

	function rpcpost($url, $params=array())
	{
		$curl = curl_init("{$this->proto}://{$this->host}:{$this->port}{$url}");
		$pop = array_pop($params);
		if (is_object($pop) || is_array($pop)) {
			$params = (object) $pop;
		}
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($curl, CURLOPT_POST, true);
		return $this->rpcrequest($curl);
	}

}
