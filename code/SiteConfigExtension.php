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
					'AnalyticsYahooTrackingId' => 'Text',
					'KeywordSuggestionEnabled' => 'Boolean(1)',
					'KeywordSuggestionQuantity' => 'Int(15)',
					'KeywordSuggestionMinimumLength' => 'Int(4)',
					'SocialNetworkingTwitterEnabled' => 'Boolean(0)',
					'SocialNetworkingTwitterUpdateDelay' => 'Int(720)',
					'SocialNetworkingTwitterConsumerKey' => 'Varchar(64)',
					'SocialNetworkingTwitterConsumerSecret' => 'Varchar(64)',
					'SocialNetworkingTwitterUserToken' => 'Varchar(64)',
					'SocialNetworkingTwitterUserSecret' => 'Varchar(64)'
				),
				'has_many' => array(
					'YahooAnalyticsVariables' => 'YahooAnalyticsVariable', /* This stores a list of configurable variables for YWA. */
					'ExcludedWords' => 'ExcludedWord'
				)
			);
		}

		/* New/modified fields for the CMS. */
		public function updateCMSFields($fields) {
		
			/* Description for Global Metadata. */
			$global_metadata_description = '<p>Any data entered into the fields below will be appended before the metadata specified for any page on the website. It will also be used as the default data for pages that have not yet had metadata configured.</p>';
			$global_metadata_advanced_options_description = '<p>Click a link below to force all pages on this site to the value of the applicable option.<ul id="GlobalMetadata_Force"><li>Append global keywords: <a class="MetaKeywords Yes" href="#">Yes</a> or <a class="MetaKeywords No" href="#">No</a>.</li><li>Append global description: <a class="MetaDescription Beginning" href="#">Beginning</a>, <a class="MetaDescription End" href="#">End</a> or <a class="MetaDescription No" href="#">No</a>.</li><li>Append global custom meta tags: <a class="ExtraMeta Yes" href="#">Yes</a> or <a class="ExtraMeta No" href="#">No</a>.</li></p>';
			
			/* Social Networking help. */
			$social_networking_twitter_help = '<p>Your website can automate the \'tweet\' of recent updates by linking it with your Twitter account. You will need to <a href="https://dev.twitter.com/apps/new" target="_blank">register your website</a> as an application. You can then retrieve your <strong>Consumey Key</strong> and <strong>Consumer Secret</strong> by visiting the application you just registered under your <a href="https://dev.twitter.com/apps" target="_blank">list of registered applications</a>. Finally, you will need to provide the <strong>Access Token</strong> and <strong>Access Token Secret</strong> for your Twitter account via the "My Access Token" button on your application page.</p>';
			
			/* Analytics help. */
			$google_analytics_help = '<p>A free account is required to utilize Google Analytics. You can <a href="http://analytics.google.com/" target="_blank">register here</a>, or sign in to your existing account to retrieve your account number <a href="https://www.google.com/accounts/ServiceLogin?service=analytics" target="_blank">here</a>.</p>';
			$yahoo_analytics_help = '<p>An account is required to utilize Yahoo! Web Analytics. You can <a href="http://web.analytics.yahoo.com/lead_form" target="_blank">register here</a>, or sign in to your existing account to retrieve your tracking Id <a href="https://login.yahoo.com/config/login_verify2?.done=https://reports.web.analytics.yahoo.com/IndexTools/servlet/IndexTools/template/Login.vm" target="_blank">here</a>. Please note that this is a premium service and comes at a cost. It would be advisable to use Google Analytics unless you have a prior arrangement with Yahoo! Web Analytics.</p>';
			$yahoo_analytics_variables_help = '<p>You can use the form below to configure the advanced options for Yahoo! Web Analytics. Documentation about the variables available to you and how to use them is <a href="http://help.yahoo.com/l/us/yahoo/smallbusiness/store/analytics/advanced/advanced-02.html" target="_blank">available here</a>.</p>';
			
			/* Keyword suggestion help. */
			$keyword_suggestion_help = '<p>You may configure the keyword suggestion feature that appears on all pages below. If you find the CMS slows down with this enabled please consider either disabling the feature or setting the maximum content length for keyword suggestion to a lower value.</p>';
			$keyword_exclusion_help = '<p>These words will NOT be offered as keyword suggestions. The larger and more comprehensive this list the better.</p>';
		
			/* Set up the tabs we need in advance. */
			$fields->addFieldToTab('Root',
				new TabSet('SearchEngineOptimization',
					new Tab('GlobalMetadata'),
					new TabSet('SocialNetworking',
						new Tab('Twitter')
						//new Tab('Facebook')
					),
					new Tab('KeywordSuggestion'),
					new TabSet('Analytics',
						new Tab('GoogleAnalytics', 'Google Analytics'),
						new Tab('YahooWebAnalytics', 'Yahoo! Web Analytics')
						//new Tab('NielsenNetView', 'Nielsen NetView')
					)
				)
			);
		
			/* Global Metadata fields. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new HeaderField('GlobalMetadataHeader', _t('SiteConfig.GlobalMetadataHeader', 'Global Metadata')));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new LiteralField('GlobalMetadataDescription', _t('SiteConfig.GlobalMetadataDescription', $global_metadata_description)));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new TextareaField('MetaKeywords', _t('SiteConfig.MetaKeywords', 'Keywords'), 1));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new TextareaField('MetaDescription', _t('SiteConfig.MetaDescription', 'Description')));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new TextareaField('ExtraMeta', _t('SiteConfig.ExtraMeta', 'Custom Meta Tags')));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new HeaderField('GlobalMetadataAdvancedOptionsHeader', 'Advanced options', 4));
			$fields->addFieldToTab('Root.SearchEngineOptimization.GlobalMetadata', new LiteralField('GlobalMetadataAdvancedOptionsDescription', $global_metadata_advanced_options_description));
			
			/* Social Networking: Twitter fields. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new HeaderField('SocialNetworkingTwitterHeader', 'Twitter'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new LiteralField('SocialNetworkingTwitterHelp', $social_networking_twitter_help));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new CheckboxField('SocialNetworkingTwitterEnabled', 'Enable auto-tweeting of recent changes'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new TextField('SocialNetworkingTwitterUpdateDelay', 'Minimum time between tweets to prevent \'spam posts\' (minutes, default: 720 - 10 hours)'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new TextField('SocialNetworkingTwitterConsumerKey', 'Consumer Key'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new TextField('SocialNetworkingTwitterConsumerSecret', 'Consumer Secret'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new TextField('SocialNetworkingTwitterUserToken', 'User Token'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.SocialNetworking.Twitter', new TextField('SocialNetworkingTwitterUserSecret', 'User Secret'));
			
			/* Keyword Suggestion fields. */
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new HeaderField('KeywordSuggestionHeader', 'Keyword Suggestion'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new LiteralField('KeywordSuggestionHelp', $keyword_suggestion_help));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new CheckboxField('KeywordSuggestionEnabled', 'Enable keyword suggestion'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new HeaderField('KeywordAdvancedOptionsHeader', 'Advanced options', 4));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new NumericField('KeywordSuggestionQuantity', 'Maximum keywords to suggest (Default: 15)'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new NumericField('KeywordSuggestionMinimumLength', 'Minimum length of keyword to suggest (Default: 4)'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new HeaderField('KeywordExclusionHeader', 'Excluded words', 4));
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', new LiteralField('KeywordExclusionHelp', $keyword_exclusion_help));
			$excluded_words = new ComplexTableField(
				$this,
				'ExcludedWords',
				'ExcludedWord',
				null,
				null,
				'"SiteConfigID" = '.SiteConfig::current_site_config()->ID
			);
			$fields->addFieldToTab('Root.SearchEngineOptimization.KeywordSuggestion', $excluded_words);

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
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new HeaderField('AnalyticsYahooVariablesHeader', 'Variables', 4));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', new LiteralField('AnalyticsYahooVariablesHelp', $yahoo_analytics_variables_help));
			$yahoo_analytics_variables = new ComplexTableField(
				$this,
				'YahooAnalyticsVariables',
				'YahooAnalyticsVariable',
				null,
				null,
				'"SiteConfigID" = '.SiteConfig::current_site_config()->ID
			);
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.YahooWebAnalytics', $yahoo_analytics_variables);
			
			/* Analytics: Nielsen NetView fields. */
			/*$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new HeaderField('AnalyticsNielsenHeader', 'Nielsen NetView', 3));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new CheckboxField('AnalyticsNielsenEnable', 'Enable Nielsen analytics'));
			$fields->addFieldToTab('Root.SearchEngineOptimization.Analytics.NielsenNetView', new TextField('AnalyticsNielsenAccountNumber', 'Account Number (e.g. UA-12345678-9)'));*/
			
			/* Load JS required for some of the additions to the CMS. */
			Requirements::javascript('neoseo/javascript/neoseo-siteconfig-global-metadata.js');
			
			return $fields;
		}
		
		static function excluded_word_list() {
		
			/* Read list. */
			$excluded_word_set = DataObject::get('ExcludedWord', '"SiteConfigID" = '.SiteConfig::current_site_config()->ID);
			
			/* Return blank array if list was empty. */
			if(!$excluded_word_set->exists()) return array();
			
			/* Generate array of excluded words. */
			$excluded_words = array();
			foreach($excluded_word_set as $excluded_word) $excluded_words[] = $excluded_word->Word;
		
			/* Return our array of excluded words. */
			return $excluded_words;
		}
		
		function onBeforeWrite() {
			
			/* Ensure the following variables are sensible (could cause horrendous errors). */
			if($this->owner->KeywordSuggestionQuantity < 1 or $this->owner->KeywordSuggestionQuantity > 32) $this->owner->KeywordSuggestionQuantity = 15;
			if($this->owner->KeywordSuggestionMinimumLength < 3 or $this->owner->KeywordSuggestionMinimumLength > 16) $this->owner->KeywordSuggestionMinimumLength = 4;
			
			parent::onBeforeWrite();
		}
		
	}

?>