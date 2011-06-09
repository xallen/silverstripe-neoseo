<?php
	class CMSMainExtension extends Extension {
	
		public function hype($urlParams, $form) {
			$id = $_REQUEST['ID'];
			Versioned::reading_stage('Live');
			$record = DataObject::get_by_id("SiteTree", $id);
			if($record && !($record->canDelete() && $record->canDeleteFromLive())) return Security::permissionFailure($this);
			
			$descRemoved = '';
			$descendantsRemoved = 0;
			
			FormResponse::status_message('Hyped page via Social Networking', 'good');

			return FormResponse::respond();
		}
		
	}
?>