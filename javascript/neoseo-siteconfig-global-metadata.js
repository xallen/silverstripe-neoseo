var _AJAX_WORKING = false;

function showWorkingMessage() {
	_AJAX_WORKING = true;
	statusMessage('Working... Please be patient.', '', true);
}

Behaviour.register({
	/* Force all pages to use global keywords. */
	'a#GlobalMetadata_ForceGlobalKeywordsYes': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				showWorkingMessage();
				new Ajax.Request('admin/force_append_setting?name=test_test_01', {
					method: 'get',
					onSuccess: function(transport) {
						statusMessage('Test ok.', 'good');
					}
				});
			}
			return false;
		}
	},
	/* Force all pages to NOT use global keywords. */
	'a#GlobalMetadata_ForceGlobalKeywordsNo': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to stop using global keywords. Proceed?")) {
				showWorkingMessage();
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceGlobalDescriptionBeginning': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				showWorkingMessage();
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceGlobalDescriptionEnd': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				showWorkingMessage();
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceGlobalDescriptionNo': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				showWorkingMessage();
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceExtraMetaYes': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				showWorkingMessage();
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceExtraMetaNo': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				showWorkingMessage();
			}
			return false;
		}
	},
	
});
