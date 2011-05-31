<?php

	/* Extend SiteConfig class to use our SEO DataObjectDecorator. */
	DataObject::add_extension('SiteConfig', 'SiteConfigExtension');
	Object::add_extension('LeftAndMain', 'LeftAndMainExtension');
	Object::add_extension('CMSMain', 'CMSMainExtension');
	DataObject::add_extension('SiteTree', 'SiteTreeExtension');
	
	LeftAndMain::require_css('neoseo/css/neoseo-leftandmain.css');

?>