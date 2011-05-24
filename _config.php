<?php

	/* Extend SiteConfig class to use our SEO DataObjectDecorator. */
	DataObject::add_extension('SiteConfig', 'SiteConfigSEO');

?>