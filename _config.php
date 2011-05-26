<?php

	/* Extend SiteConfig class to use our SEO DataObjectDecorator. */
	DataObject::add_extension('SiteConfig', 'SiteConfigExtension');
	DataObject::add_extension('SiteTree', 'SiteTreeExtension');
	
	LeftAndMain::require_css('neoseo/css/neoseo-leftandmain.css');
	
	SiteTreeExtension::set_exclude_words('about, again, also, been, before, cause, come, could, default, does, each, edit, even, from, give, have, here, just, like, made, many, most, much, must, only, other, said, same, should, since, some, such, tell, than, that, their, them, then, there, these, they, thing, this, through, very, want, welcome, well, were, what, when, where, which, while, will, with, within, would, your');

?>