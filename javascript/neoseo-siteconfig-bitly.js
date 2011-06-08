Behaviour.register({
	/* Force all pages to use global keywords. */
	'#SocialNetworking_Bitly_Diagnostics': {
		onclick: function() {
		
			/* Update the user's interface. */
			statusMessage('Testing... Please be patient.', '', true);
			
			/* Split class list to obtain the paramaters we require for submission. */
			var paramaters = this.className.split(' ');
			
			/* Handle the actual submission. */
			new Ajax.Request('/admin/test_bitly', {
				method: 'post',
				onSuccess: function(transport) {
					
					/* Update the user's interface with the result. */
					eval(transport.responseText);
				}
			});
				
			return false;
		}
	}
});
