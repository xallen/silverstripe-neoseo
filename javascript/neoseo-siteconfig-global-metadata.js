Behaviour.register({
	/* Force all pages to use global keywords. */
	'#GlobalMetadata_Force a': {
		onclick: function() {
		
			/* Warn the user and give them a way out. */
			if(!confirm("This will force every page to use this setting. Proceed?")) return false;
				
			/* Update the user's interface. */
			statusMessage('Working... Please be patient.', '', true);
			
			/* Split class list to obtain the paramaters we require for submission. */
			var paramaters = this.className.split(' ');
			
			/* Handle the actual submission. */
			new Ajax.Request('/admin/force_append_setting', {
				method: 'post',
				postBody:  'name=' + paramaters[0] + '&value=' + paramaters[1],
				onSuccess: function(transport) {
					
					/* Update the user's interface with the result. */
					eval(transport.responseText);
				}
			});
				
			return false;
		}
	}
});
