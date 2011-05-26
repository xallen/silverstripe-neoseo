Behaviour.register({
	/* Handle appending the suggested keywords to the MetaKeywords TextField. */
	'a#NeoSEO_KeywordAppend': {
		onclick: function() {
			/* If the MetaKeywords Textfield is blank we can just fill the field. */
			if($('Form_EditForm_MetaKeywords').value === "") {
				$('Form_EditForm_MetaKeywords').value = $('NeoSEO_Keywords').innerHTML;
			} else {
				$('Form_EditForm_MetaKeywords').value += (", " + $('NeoSEO_Keywords').innerHTML);
			}
			return false;
		}
	},
	/* Handle replacing the keywords in MetaKeywords TextField with the suggested keywords. */
	'a#NeoSEO_KeywordReplace': {
		onclick: function() {
			/* Warn the user and give them a way out. */
			if(confirm("This will replace your existing keywords. Proceed?")) {
				$('Form_EditForm_MetaKeywords').value = $('NeoSEO_Keywords').innerHTML;
			}
			return false;
		}
	}
});
