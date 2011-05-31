<?php

	class LeftAndMainExtension extends Extension {
	
		/* List of functions allowed to handle requests. */
		static $allowed_actions = array('force_append_setting');

		public function force_append_setting() {
		
			/* We need these paramaters from the POST data. */
			$name = $_REQUEST['name'];
			$value = $_REQUEST['value'];
			
			/* Handle the actual DB manipulation here. */
			switch($name) {
				case 'MetaKeywords':
					DB::query('UPDATE `SiteTree` SET `MetaKeywordsAppend` = '.(($value == 'Yes') ? 1 : 0).' WHERE `ID` = '.SiteConfig::current_site_config()->ID);
					return 'statusMessage("Global metadata keywords have been '.(($value == 'Yes') ? 'enabled' : 'disabled').' for all pages.", "good");';
				case 'MetaDescription':
				case 'ExtraMeta':
					DB::query('UPDATE `SiteTree` SET `ExtraMetaAppend` = '.(($value == 'Yes') ? 1 : 0).' WHERE `ID` = '.SiteConfig::current_site_config()->ID);
					return 'statusMessage("Global custom metadata tags have been '.(($value == 'Yes') ? 'enabled' : 'disabled').' for all pages.", "good");';
			}
			
			/* If we haven't returned before this the request must have been bad. */
			return 'errorMessage("Invalid request.");';
		}
	}

?>