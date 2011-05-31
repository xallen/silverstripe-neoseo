<?php

	class SiteTreeExtension extends DataObjectDecorator {
	
		/* Append parent's static variables. */
		function extraStatics() {
		
			return array(
				/* Database fields. */
				'db' => array(
					'MetaKeywordsAppend' => 'Boolean(1)',
					'MetaDescriptionAppend' => 'Enum("Beginning, End, No")',
					'ExtraMetaAppend' => 'Boolean(1)'
				),
				/* Default database field values. */
				'defaults' => array(
					'MetaDescriptionAppend' => 'Beginning',
				)
			);
		}
	
		/**
		 * Return the title, description, keywords and language metatags.
		 * 
		 * @param string $tags Reference to the tags generated by the parent class
		 */
		public function MetaTags(&$tags) {
			
			/* HACK ALERT: Was $includeTitle set in the calling function? */
			strpos($tags, '<title>') ? $includeTitle = true : $includeTitle = false;
			
			$site_config = SiteConfig::current_site_config();
			
			$tags = "";
			
			if($includeTitle) {
				$tags .= "<title>" . Convert::raw2xml(($this->MetaTitle) ? $this->MetaTitle : $this->Title) . "</title>\n";
			}

			$tags .= "<meta name=\"generator\" content=\"SilverStripe - http://silverstripe.org\" />\n";

			$charset = ContentNegotiator::get_encoding();
			$tags .= "<meta http-equiv=\"Content-type\" content=\"text/html; charset=$charset\" />\n";
			if($this->owner->MetaKeywords || ($site_config->MetaKeywords and $this->owner->MetaKeywordsAppend)) {
				$keywords = array();
				if($site_config->MetaKeywords and $this->owner->MetaKeywordsAppend) $keywords[] = $site_config->MetaKeywords;
				if($this->owner->MetaKeywords) $keywords[] = $this->owner->MetaKeywords;
				$tags .= "<meta name=\"keywords\" content=\"" . Convert::raw2att(implode(', ', $keywords)) . "\" />\n";
			}
			if($this->owner->MetaDescription || ($site_config->MetaDescription and $this->owner->MetaDescriptionAppend != 'No')) {
				$description = array();
				if($site_config->MetaDescription and $this->owner->MetaDescriptionAppend == 'Beginning') $description[] = $site_config->MetaDescription;
				if($this->owner->MetaDescription) $description[] = $this->owner->MetaDescription;
				if($site_config->MetaDescription and $this->owner->MetaDescriptionAppend == 'End') $description[] = $site_config->MetaDescription;
				$tags .= "<meta name=\"description\" content=\"" . Convert::raw2att(implode(' ', $description)) . "\" />\n";
			}
			if($this->owner->ExtraMeta || ($site_config->ExtraMeta and $this->owner->ExtraMetaAppend)) { 
				if($this->owner->ExtraMeta) $tags .= $this->owner->ExtraMeta . "\n";
				if($site_config->ExtraMeta and $this->owner->ExtraMetaAppend) $tags .= $site_config->ExtraMeta . "\n";
			}
			
			/* Here we add the code required for analytics for each vendor. */
			
			/* Google Analytics. */
			if($site_config->AnalyticsGoogleEnabled and $site_config->AnalyticsGoogleAccountNumber) {
				$tags .= "
				<script type=\"text/javascript\">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '{$site_config->AnalyticsGoogleAccountNumber}']);
				_gaq.push(['_trackPageview']);
				(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();
				</script>
				";
			}
			
			/* Yahoo! Web Analytics. */
			if($site_config->AnalyticsYahooEnabled and $site_config->AnalyticsYahooTrackingId) {
			
				/* Parse YWA Variables to JavaScript. */
				$ywa_variables = "";
				foreach($site_config->YahooAnalyticsVariables() as $variable) {
					$ywa_variables .= "
					YWATracker.set{$variable->Name}(\"{$variable->Value}\");\n
					";
				}
			
				$tags .= "
				<script type=\"text/javascript\" src=\"http://d.yimg.com/mi/ywa.js\"></script>
				<script type=\"text/javascript\">
				YWATracker = YWA.getTracker(\"{$site_config->AnalyticsYahooTrackingId}\");
				{$ywa_variables}
				YWATracker.submit();
				</script>
				";
			}
			
		}
		
		/* New/modified fields for the CMS. */
		public function updateCMSFields($fields) {
			
			$fields->addFieldToTab('Root.Content.Metadata', new CheckboxField('MetaKeywordsAppend', 'Append global keywords?'), 'MetaDescription');
			$fields->addFieldToTab('Root.Content.Metadata', new DropdownField('MetaDescriptionAppend', 'Append global description?',  array('Beginning' => 'Yes, to the beginning', 'End' => 'Yes, to the end', 'No' => 'No')), 'ExtraMeta');
			$fields->addFieldToTab('Root.Content.Metadata', new CheckboxField('ExtraMetaAppend', 'Append global custom meta tags?'));
			
			/* Generate the list of suggested keywords. */
			$suggested_keywords = $this->generateKeywords();
			
			/* Are there keyword suggestions available? */
			if($suggested_keywords !== '') {
			
				/* Fill the suggestion field. This sets up the field so we can utilize Prototype later. */
				$suggested_keywords_literal = "<p id=\"MetaKeywordsSuggestion\"><strong>Suggested keywords:</strong> <span id=\"NeoSEO_Keywords\">{$suggested_keywords}</span>.<br/><a id=\"NeoSEO_KeywordAppend\" href=\"#\">Append these keywords</a> | <a id=\"NeoSEO_KeywordReplace\" href=\"#\">Replace existing keywords with these keywords</a></p>";
				
				/* Insert the suggestion LiteralField in to the Metadata FieldSet. */
				$fields->addFieldToTab('Root.Content.Metadata', new LiteralField('MetaKeywordsSuggestion', $suggested_keywords_literal), 'MetaKeywordsAppend');
				
				/* Utilize external JS (via Prototype) for form manipulation. */
				Requirements::javascript('neoseo/javascript/neoseo-sitetree-metadata.js');
			}
			
			return $fields;
		}
		
		private function generateKeywords() {
			
			/* Return if suggestion is disabled. */
			if(!SiteConfig::current_site_config()->KeywordSuggestionEnabled) return '';
			
			/* Content to search through comes from the SiteTree field Content. */
			$string = $this->owner->Content;
			
			/* TODO: RE(test). CamelCase matching (important nouns!) */
			preg_match_all('/\b([A-Z][a-z]*)+[A-Z][a-z]+([A-Z][a-z]*)*\b/ ', $string, $matches);
			
			/* SiteConfig supplies the following variables with their data from the CMS. */
			$min_word_char = SiteConfig::current_site_config()->KeywordSuggestionMinimumLength;
			$keyword_amount = SiteConfig::current_site_config()->KeywordSuggestionQuantity;
			$exclude_words = SiteConfigExtension::excluded_word_list();
			
			//add space before br tags so words aren't concatenated when tags are stripped
			$string = preg_replace('/\<br(\s*)?\/?\>/i', " <br />", $string); 
			// get rid off the htmltags
			$string = html_entity_decode(strip_tags($string), ENT_NOQUOTES , 'UTF-8');
			
			// count all words with str_word_count_utf8
			$initial_words_array  = self::str_word_count_utf8($string, 1);
			$total_words = sizeof($initial_words_array);
			
			$new_string = $string;
			
			//convert to lower case
			$new_string = mb_convert_case($new_string, MB_CASE_LOWER, "UTF-8");
			
			// strip excluded words
			foreach($exclude_words as $filter_word)	{
				$new_string = preg_replace("/\b".$filter_word."\b/i", "", $new_string); 
			}
			
			// calculate words again without the excluded words using str_word_count_utf8
			$words_array = self::str_word_count_utf8($new_string, 1);
			$words_array = array_filter($words_array, create_function('$var', 'return (strlen($var) >= '.$min_word_char.');'));
			
			$popularity = array();
			$unique_words_array = array_unique($words_array);
			
			// create density array
			foreach($unique_words_array as  $key => $word)	{
				preg_match_all('/\b'.$word.'\b/i', $string, $out);
				$count = count($out[0]);	
				$popularity[$key]['count'] = $count;
				$popularity[$key]['word'] = $word;
				
			}
			
			usort($popularity, array($this,'cmp'));
			
			// sort array form higher to lower
			krsort($popularity);
			
			// create keyword array with only words
			$keywords = array();
			foreach($popularity as $value){
							$keywords[] = $value['word']; 
						}
						
			// glue keywords to string seperated by comma, maximum 15 words
			$keystring =  implode(', ', array_slice($keywords, 0, $keyword_amount));
			
			// return the keywords
			return $keystring;
		}

		/**
		 * Sort array by count value
		 */
		private static function cmp($a, $b) {
			return ($a['count'] > $b['count']) ? +1 : -1;
		}

		/** Word count for UTF8
		/* Found in: http://www.php.net/%20str_word_count#85592
		/* The original mask contained the apostrophe, not good for Meta keywords:
		/* "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}..."
		*/
		private static function str_word_count_utf8($string, $format = 0) {
			switch ($format) {
			case 1:
				preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}]*/u", $string, $matches);
				return $matches[0];
			case 2:
				preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}]*/u", $string, $matches, PREG_OFFSET_CAPTURE);
				$result = array();
				foreach ($matches[0] as $match) {
					$result[$match[1]] = $match[0];
				}
				return $result;
			}
			return preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}]*/u", $string, $matches);
		}
		
		function onAfterPublish() {
			SiteConfigExtension::tweet();
		}
		
	}

?>