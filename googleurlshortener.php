<?php
 
if (!function_exists('curl_init')) {
    trigger_error('The cURL extension is required for the use of this class');
}
 
class googleurlshortener{
 
	private static $googleShortenerUrl = 'https://www.googleapis.com/urlshortener/v1/url';
 
	public static function shortenurl($url)
	{
		if (!preg_match('/((https?|ftps?)://)((d{1,3}.){3}d{1,3}|[a-z0-9-.]{1,255}.[a-zA-Z]{2,6})(:d{1,5})?(/S*)*/',$url))
		{
			return false;
		}
		$curl = curl_init(self::$googleShortenerUrl);
		curl_setopt_array($curl, array (CURLOPT_HTTPHEADER     => array('Content-Type: application/json')
										,CURLOPT_RETURNTRANSFER => 1
                                        ,CURLOPT_TIMEOUT        => 5
                                        ,CURLOPT_CONNECTTIMEOUT => 0
                                        ,CURLOPT_POST           => 1
                                        ,CURLOPT_SSL_VERIFYHOST => 0
                                        ,CURLOPT_SSL_VERIFYPEER => 0
                                        ,CURLOPT_POSTFIELDS     => '{"longUrl": "' . $url . '"}'));
		$curlRetValue = json_decode(curl_exec($curl), true);
		return (!empty($curlRetValue['id']) ? $curlRetValue['id'] : $url);
	}
 
	public static function expandurl($url)
	{
		if (!preg_match('/http://goo.gl/(.*)/i', $url))
		{
            return false;
        }
        $curl = curl_init(self::$googleShortenerUrl.'?shortUrl='.$url);
        curl_setopt_array($curl, array (CURLOPT_RETURNTRANSFER => 1
                                        ,CURLOPT_TIMEOUT        => 5
                                        ,CURLOPT_CONNECTTIMEOUT => 0
                                        ,CURLOPT_SSL_VERIFYHOST => 0
                                        ,CURLOPT_SSL_VERIFYPEER => 0));
		$curlRetValue = json_decode(curl_exec($curl), true);
		return (!empty($curlRetValue['longUrl']) ? $curlRetValue['longUrl'] : $url);
	}
}