<?php
	
	class BitlyURL extends DataObject {
		
		static $db = array(
			'ShortURL' => 'Varchar(60)',
			'FullURL' => 'Varchar(255)'
		);
		
		/* Make a URL small via Bit.ly's API. */
		private function make_bitly_url($url, $login, $appkey) {
			$bitly = 'http://api.bit.ly/shorten?version=2.0.1&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format=json';
			$response = file_get_contents($bitly); /* CURL instead? */
			$json = @json_decode($response, true);
			return $json['results'][$url]['shortUrl'];
		}
		
		function onBeforeWrite() {
		
			/* If FullURL is set, we must build ShortURL. */
			if($this->FullURL)
				$this->ShortURL = $this->make_bitly_url('http://allenmara.co.nz/cache.php?url='.$this->FullURL, 'xallen', 'R_28e24e6e117ac91fa15ce51561d3fb41');
		
			parent::onBeforeWrite();
		}

	}

?>