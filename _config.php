<?php

	/* Extend SiteConfig class to use our SEO DataObjectDecorator. */
	DataObject::add_extension('SiteConfig', 'SiteConfigExtension');
	DataObject::add_extension('SiteTree', 'SiteTreeExtension');
	
	LeftAndMain::require_css('neoseo/css/neoseo-leftandmain.css');

?>