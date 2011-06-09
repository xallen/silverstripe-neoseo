<?php
	
	class BitlyURL extends DataObject {
		
		static $db = array(
			'Hash' => 'Varchar(6)',
			'FullURL' => 'Varchar(255)'
		);
		
		function Domain() {
			return SiteConfig::current_site_config()->SocialNetworkingBitlyDomain;
		}
		
		function Link() {
		
			/* If we have a hash we need to build the URL at this point and return it. */
			if($this->Hash) { 
				return Controller::join_links('http://', $this->Domain(), $this->Hash);
			}
			
			/* Default to the full URL. */
			return $this->FullURL;
		}
		
		private static function api_execute($function, $paramaters = array()) {
			
			/* Here we set the default, required values if required. */
			if(!in_array('login', $paramaters)) $paramaters['login'] = SiteConfig::current_site_config()->SocialNetworkingBitlyUsername;
			if(!in_array('apiKey', $paramaters)) $paramaters['apiKey'] = SiteConfig::current_site_config()->SocialNetworkingBitlyApplicationKey;
			
			/* Build HTTP arguments based on the paramaters we have. */
			$arguments = http_build_query($paramaters);
			
			/* Execute the entire query, incl. arguments and execute it. */
			$response = @file_get_contents("http://api.bit.ly/v3/{$function}?{$arguments}");
			
			/* Return decoded response. */
			return @json_decode($response, true);
		}
		
		/* Shorten an URL. */
		static function shorten($url) {
			return BitlyURL::api_execute('shorten', array('longURL' => $url));
		}
		
		/* Check whether our query succeed or not. */
		static function api_query_successful(&$response) {
			/* The status_code index must exist and equal 200, else failure. */
			return isset($response['status_code']) and intval($response['status_code']) == 200;
		}
		
		function onBeforeWrite() {
		
			/* Build a hash if we have a full URL to work with. */
			if($this->FullURL) {
				
				/* Query via API. */
				$response = BitlyURL::shorten("http://allenmara.co.nz/cache.php?id={$this->FullURL}");

				/* If our query was successful, set the Hash in db to returned hash. */
				if(BitlyURL::api_query_successful($response)) {
					$this->Hash = $response['data']['hash'];
				}				
			}
		
			parent::onBeforeWrite();
		}

	}

?>