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
					'AnalyticsGoogleAccountNumber' => 'Text'
				)
			);
		}

		/* New/modified fields for the CMS. */
		public function updateCMSFields($fields) {
		
			/* Description for Global Metadata. */
			$global_metadata_description = '<p>Any data entered into the fields below will be appended before the metadata specified for any page on the website. It will also be used as the default data for pages that have not yet had metadata configured.</p><p>&nbsp;</p>';
			
			/* Analytics Help. */
			$google_analytics_help = '<p>A free account is required to utilize Google Analytics. You can <a href="http://analytics.google.com/" target="_blank">register here</a>, or sign in to your existing account to retrieve your account number <a href="https://www.google.com/accounts/ServiceLogin?service=analytics" target="_blank">here</a>.</p>';
		
			/* Set up the tabs we need in advance. */
			$fields->addFieldToTab('Root',
				new TabSet('SearchEngineOptimization',
					new Tab('GlobalMetadata'), 
					new TabSet('Analytics',
						new Tab('GoogleAnalytics', 'Google Analytics')
						//new Tab('YahooAnalytics', 'Yahoo! Analytics'),
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
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.GoogleAnalytics', new CheckboxField('AnalyticsGoogleEnabled', 'Enable Google analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.GoogleAnalytics', new TextField('AnalyticsGoogleAccountNumber', 'Account Number (e.g. UA-12345678-9)'));
			
			/* Analytics: Yahoo! Analytics fields. */
			/*$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooAnalytics', new HeaderField('AnalyticsYahooHeader', 'Yahoo! Analytics', 3));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooAnalytics', new CheckboxField('AnalyticsYahooEnable', 'Enable Yahoo analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooAnalytics', new TextField('AnalyticsYahooAccountNumber', 'Account Number (e.g. UA-12345678-9)'));*/
			
			/* Analytics: Nielsen NetView fields. */
			/*$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new HeaderField('AnalyticsNielsenHeader', 'Nielsen NetView', 3));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new CheckboxField('AnalyticsNielsenEnable', 'Enable Nielsen analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new TextField('AnalyticsNielsenAccountNumber', 'Account Number (e.g. UA-12345678-9)'));*/
			
			return $fields;
		}
		
	}

?>