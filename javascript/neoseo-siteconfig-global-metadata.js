Behaviour.register({
	/* Force all pages to use global keywords. */
	'a#GlobalMetadata_ForceGlobalKeywordsYes': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				alert("MetaKeywords(YES). Functionality pending!");
			}
			return false;
		}
	},
	/* Force all pages to NOT use global keywords. */
	'a#GlobalMetadata_ForceGlobalKeywordsNo': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to stop using global keywords. Proceed?")) {
				alert("MetaKeywords(NO). Functionality pending!");
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceGlobalDescriptionBeginning': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				alert("MetaDescription(YES). Functionality pending!");
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceGlobalDescriptionEnd': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				alert("MetaDescription(END). Functionality pending!");
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceGlobalDescriptionNo': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				alert("MetaDescription(NO). Functionality pending!");
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceExtraMetaYes': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				alert("ExtraMeta(YES). Functionality pending!");
			}
			return false;
		}
	},
	'a#GlobalMetadata_ForceExtraMetaNo': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will force every page to use the global keywords. Proceed?")) {
				alert("ExtraMeta(NO). Functionality pending!");
			}
			return false;
		}
	},
	
});
