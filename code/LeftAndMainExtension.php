<?php

	class LeftAndMainExtension extends Extension {
	
		/* List of functions allowed to handle requests. */
		static $allowed_actions = array('force_append_setting');

		/* TODO: Add Subsite support - further filter consideration. */
		public function force_append_setting() {
		
			/* We need these paramaters from the POST data. */
			$name = $_REQUEST['name'];
			$value = $_REQUEST['value'];
			
			/* Handle the actual DB manipulation here. */
			switch($name) {
				case 'MetaKeywords':
					DB::query('UPDATE `SiteTree` SET `MetaKeywordsAppend` = '.(($value == 'Yes') ? 1 : 0));
					return 'statusMessage("Global metadata keywords have been '.(($value == 'Yes') ? 'enabled' : 'disabled').' for all pages.", "good");';
				case 'MetaDescription':
					if($value != 'Beginning' and $value != 'End') $value = 'No'; /* Make sure the data is safe. If it isn't Beginning or End it is set to No. */
					DB::query('UPDATE `SiteTree` SET `MetaDescriptionAppend` = \''.$value.'\'');
					return 'statusMessage("Global metadata description has been '.(($value == 'No') ? 'disabled' : 'enabled').' on all pages.", "good");';
				case 'ExtraMeta':
					DB::query('UPDATE `SiteTree` SET `ExtraMetaAppend` = '.(($value == 'Yes') ? 1 : 0));
					return 'statusMessage("Global custom metadata tags have been '.(($value == 'Yes') ? 'enabled' : 'disabled').' for all pages.", "good");';
			}
			
			/* If we haven't returned before this the request must have been bad. */
			return 'errorMessage("Invalid request.");';
		}
	}
	
?>