<?php

	/* Model to hold words excluded from keyword suggestions. */
	class ExcludedWord extends DataObject {
	
		static $db = array(
			'Word' => 'Varchar(32)'
		);
		
		static $has_one = array(
			'SiteConfig' => 'SiteConfig'
		);
	
		static $summary_fields = array(
			'Word'
		);
		
		static $default_sort = 'Word';
		
		function onBeforeWrite() {
		
			/* HACK/TODO: Force SiteConfigID to current SiteConfig ID. I couldn't work
			 * out why the relationship wasn't working to begin with.
			 */
			$this->SiteConfigID = SiteConfig::current_site_config()->ID;
			
			/* Force lowercase on Word (aesthetic purposes only!) */
			$this->Word = strtolower($this->Word);
			
			parent::onBeforeWrite();
		}
		
		/* Insert default excluded words list. */
		function requireDefaultRecords() {
			parent::requireDefaultRecords();
			
			/* Exclusion list empty? Better fix that! */
			$excluded_word = DataObject::get_one('ExcludedWord');
			if(!$excluded_word) {
				
				/* These words will be added one-by-one as exclusions. */
				$default_list = array('about', 'again', 'also', 'been', 'before', 'cause', 'come', 'could', 'default',
					'does', 'each', 'edit', 'even', 'from', 'give', 'have', 'here', 'just', 'like', 'made', 'many', 'most',
					'much', 'must', 'only', 'other', 'said', 'same', 'should', 'since', 'some', 'such', 'tell', 'than',
					'that', 'their', 'them', 'then', 'there', 'these', 'they', 'thing', 'this', 'through', 'very', 'want',
					'welcome', 'well', 'were', 'what', 'when', 'where', 'which', 'while', 'will', 'with', 'within',
					'would', 'your', 'youre');
				
				/* Loop through the default list of exclusions, adding them. */
				foreach($default_list as $word) {
					$new_excluded_word = new ExcludedWord();
					$new_excluded_word->Word = $word;
					$new_excluded_word->write();
				}
				
				/* Let the user know we made their lives significantly easier. */
				DB::alteration_message('Added default list of excluded words for keyword suggestions', 'created');
			}
		}
	
	}

?>