<?php
	
	class BitlyURL extends DataObject {
		
		/* This variable is responsible for storing JSON returned data from the last request. */
		private $json;
		
		static $db = array(
			'ShortURL' => 'Varchar(60)',
			'FullURL' => 'Varchar(255)'
		);
		
		/* Return raw JSON response from the last query. */
		function getJSON() {
			return $this->json;
		}
		
		/* Failsafe URL return. */
		function Link() {
			return (($this->ShortURL) ? $this->ShortURL : $this->FullURL);
		}
		
		/* Make a URL small via Bit.ly's API. */
		private function generate_url($url, $login, $appkey) {
			$bitly = 'http://api.bit.ly/shorten?version=2.0.1&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format=json';
			$response = file_get_contents($bitly); /* CURL instead? */
			$this->json = @json_decode($response, true);
			return isset($this->json['results'][$url]['shortUrl']) ? $this->json['results'][$url]['shortUrl'] : false;
		}
		
		function onBeforeWrite() {
		
			/* If FullURL is set, we must build ShortURL. */
			if($this->FullURL)
				$this->ShortURL = $this->generate_url(
					'http://allenmara.co.nz/cache.php?url='.$this->FullURL,
					SiteConfig::current_site_config()->SocialNetworkingBitlyUsername,
					SiteConfig::current_site_config()->SocialNetworkingBitlyApplicationKey
				);
		
			parent::onBeforeWrite();
		}

	}

?>