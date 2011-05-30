<?php

	class LeftAndMainExtension extends Extension {
	
		static $allowed_actions = array(
			'force_append_setting'
		);
	
		function extraStatics() { }
	
		public function force_append_setting() {
			$name = $_REQUEST['name'];
			die($name.' forced successfully.');
		}
		
	}

?>