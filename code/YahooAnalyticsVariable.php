<?php

	/* Model to hold YWA configuration variables and their values. */
	class YahooAnalyticsVariable extends DataObject {
	
		static $db = array(
			'Name' => 'Enum("DocumentName, DocumentGroup, MemberId, CmpQuery, CookieDomain, Domains, FlashUrl")',
			'Value' => 'Varchar(128)'
		);
		
		static $has_one = array(
			'SiteConfig' => 'SiteConfig'
		);
	
		static $summary_fields = array(
			'Name',
			'Value'
		);
		
		/* HACK/TODO: Force SiteConfigID to current SiteConfig ID. I couldn't work
		 * out why the relationship wasn't working to begin with.
		 */
		function onBeforeWrite() {
			$this->SiteConfigID = SiteConfig::current_site_config()->ID;
			parent::onBeforeWrite();
		}
		
		/* NOTE: http://help.yahoo.com/l/us/yahoo/smallbusiness/store/analytics/advanced/advanced-02.html */
	
	}

?>