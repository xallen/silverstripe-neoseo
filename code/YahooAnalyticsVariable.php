<?php

	/* Model to hold YWA configuration variables and their values. */
	class YahooAnalyticsVariable extends DataObject {
	
		static $db = array(
			'Name' => 'Enum("DocumentName, DocumentGroup, MemberId, CmpQuery, CookieDomain, Domains, FlashUrl")',
			'Value' => 'Varchar(128)'
		);
	
		static $summary_fields = array(
			'Name',
			'Value'
		);
		
		/* NOTE: http://help.yahoo.com/l/us/yahoo/smallbusiness/store/analytics/advanced/advanced-02.html */
	
	}

?>