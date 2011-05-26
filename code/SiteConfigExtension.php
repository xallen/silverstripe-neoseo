<?php

	class SiteConfigExtension extends DataObjectDecorator {
	
		/* Append parent's static variables. */
		function extraStatics() {
		
			return array(
				/* Database fields. */
				'db' => array(
					'MetaDescription' => 'Text',
					'MetaKeywords' => 'Varchar(255)',
					'ExtraMeta' => 'HTMLText',
					'AnalyticsGoogleEnabled' => 'Boolean',
					'AnalyticsGoogleAccountNumber' => 'Text',
					'AnalyticsYahooEnabled' => 'Boolean',
					'AnalyticsYahooTrackingId' => 'Text'
				),
				'has_many' => array(
					'YahooAnalyticsVariables' => 'YahooAnalyticsVariable' /* This stores a list of configurable variables for YWA. */
				)
			);
		}

		/* New/modified fields for the CMS. */
		public function updateCMSFields($fields) {
		
			/* Description for Global Metadata. */
			$global_metadata_description = '<p>Any data entered into the fields below will be appended before the metadata specified for any page on the website. It will also be used as the default data for pages that have not yet had metadata configured.</p><p>&nbsp;</p>';
			
			/* Analytics Help. */
			$google_analytics_help = '<p>A free account is required to utilize Google Analytics. You can <a href="http://analytics.google.com/" target="_blank">register here</a>, or sign in to your existing account to retrieve your account number <a href="https://www.google.com/accounts/ServiceLogin?service=analytics" target="_blank">here</a>.</p>';
			$yahoo_analytics_help = '<p>An account is required to utilize Yahoo! Web Analytics. You can <a href="http://web.analytics.yahoo.com/lead_form" target="_blank">register here</a>, or sign in to your existing account to retrieve your tracking Id <a href="https://login.yahoo.com/config/login_verify2?.done=https://reports.web.analytics.yahoo.com/IndexTools/servlet/IndexTools/template/Login.vm" target="_blank">here</a>. Please note that this is a premium service and comes at a cost. It would be advisable to use Google Analytics unless you have a prior arrangement with Yahoo! Web Analytics.</p>';
			$yahoo_analytics_variables_help = '<p>You can use the form below to configure the advanced options for Yahoo! Web Analytics. Documentation about the variables available to you and how to use them is <a href="http://help.yahoo.com/l/us/yahoo/smallbusiness/store/analytics/advanced/advanced-02.html" target="_blank">available here</a>.</p>';
		
			/* Set up the tabs we need in advance. */
			$fields->addFieldToTab('Root',
				new TabSet('SearchEngineOptimization',
					new Tab('GlobalMetadata'), 
					new TabSet('Analytics',
						new Tab('GoogleAnalytics', 'Google Analytics'),
						new Tab('YahooWebAnalytics', 'Yahoo! Web Analytics')
						//new Tab('NielsenNetView', 'Nielsen NetView')
					)
				)
			);
		
			/* Global Metadata: Header and description. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new HeaderField('GlobalMetadataHeader', _t('SiteConfig.GlobalMetadataHeader', 'Global Metadata')));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new LiteralField('GlobalMetadataDescription', _t('SiteConfig.GlobalMetadataDescription', $global_metadata_description)));
			
			/* Global Metadata: Main form. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new TextareaField('MetaKeywords', _t('SiteConfig.MetaKeywords', 'Keywords'), 1));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new TextareaField('MetaDescription', _t('SiteConfig.MetaDescription', 'Description')));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new TextareaField('ExtraMeta', _t('SiteConfig.ExtraMeta', 'Custom Meta Tags')));

			/* Analytics: Google Analytics fields. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.GoogleAnalytics', new HeaderField('AnalyticsGoogleHeader', 'Google Analytics', 3));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.GoogleAnalytics', new LiteralField('AnalyticsGoogleHelp', $google_analytics_help));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.GoogleAnalytics', new CheckboxField('AnalyticsGoogleEnabled', 'Enable Google Analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.GoogleAnalytics', new TextField('AnalyticsGoogleAccountNumber', 'Account Number (e.g. UA-12345678-9)'));
			
			/* Analytics: Yahoo! Analytics fields. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new HeaderField('AnalyticsYahooHeader', 'Yahoo! Web Analytics', 3));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new LiteralField('AnalyticsYahooHelp', $yahoo_analytics_help));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new CheckboxField('AnalyticsYahooEnabled', 'Enable Yahoo! Web Analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new TextField('AnalyticsYahooTrackingId', 'Tracking Id (e.g. 1000111111111)'));
			$yahoo_analytics_variables = new ComplexTableField(
				$this,
				'YahooAnalyticsVariables',
				'YahooAnalyticsVariable'
			);
			$yahoo_analytics_variables->setParentClass('SiteConfig'); 
			$yahoo_analytics_variables->sourceId = 1;
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new HeaderField('AnalyticsYahooVariablesHeader', 'Variables', 4));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new LiteralField('AnalyticsYahooVariablesHelp', $yahoo_analytics_variables_help));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', $yahoo_analytics_variables);
			
			/* Analytics: Nielsen NetView fields. */
			/*$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new HeaderField('AnalyticsNielsenHeader', 'Nielsen NetView', 3));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new CheckboxField('AnalyticsNielsenEnable', 'Enable Nielsen analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new TextField('AnalyticsNielsenAccountNumber', 'Account Number (e.g. UA-12345678-9)'));*/
			
			return $fields;
		}
		
	}

?>