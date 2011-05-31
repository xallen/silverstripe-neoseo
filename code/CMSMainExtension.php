<?php
	class CMSMainExtension extends Extension {
	
		public function hype($urlParams, $form) {
			$id = $_REQUEST['ID'];
			Versioned::reading_stage('Live');
			$record = DataObject::get_by_id("SiteTree", $id);
			if($record && !($record->canDelete() && $record->canDeleteFromLive())) return Security::permissionFailure($this);
			
			$descRemoved = '';
			$descendantsRemoved = 0;
			
			/* before deleting the records, get the descendants of this tree
			if($record) {
				$descendantIDs = $record->getDescendantIDList();

				// then delete them from the live site too
				$descendantsRemoved = 0;
				foreach( $descendantIDs as $descID )
					if( $descendant = DataObject::get_by_id('SiteTree', $descID) ) {
						//$descendant->doDeleteFromLive();
						$descendantsRemoved++;
					}

				// delete the record
				$record->doDeleteFromLive();
			}

			Versioned::reading_stage('Stage');

			if(isset($descendantsRemoved)) {
				$descRemoved = " and $descendantsRemoved descendants";
				$descRemoved = sprintf(' '._t('CMSMain.DESCREMOVED', 'and %s descendants'), $descendantsRemoved);
			} else {
				$descRemoved = '';
			}

			FormResponse::add($this->deleteTreeNodeJS($record));
			
			*/
			
			//FormResponse::status_message(sprintf(_t('CMSMain.REMOVED', 'Deleted \'%s\'%s from live site'), $record->Title, $descRemoved), 'good');
			
			FormResponse::status_message('Hyped page via Social Networking', 'good');

			return FormResponse::respond();
		}
		
	}
?>