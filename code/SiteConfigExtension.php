<?php

	class SiteConfigExtension extends DataObjectDecorator {
	
		function extraStatics() {
		
			return array(
				'db' => array(
					'MetaDescription' => 'Text',
					'MetaKeywords' => 'Varchar(255)',
					'ExtraMeta' => 'HTMLText'
				)
			);
		}

		public function updateCMSFields($fields) {
		
			$global_metadata_description = '<p>Any data entered into the fields below will be appended before the metadata specified for any page on the website. It will also be used as the default data for pages that have not yet had metadata configured.</p>';
		
			/* Global Metadata: Header and description. */
			$fields->addFieldToTab('Root.GlobalMetadata', new HeaderField('GlobalMetadataHeader', _t('SiteConfig.GlobalMetadataHeader', 'Global Metadata')));
			$fields->addFieldToTab('Root.GlobalMetadata', new LiteralField('GlobalMetadataDescription', _t('SiteConfig.GlobalMetadataDescription', $global_metadata_description)));
			
			/* Global Metadata: Main form. */
			$fields->addFieldToTab('Root.GlobalMetadata', new TextareaField('MetaKeywords', _t('SiteConfig.MetaKeywords', 'Keywords'), 1));
			$fields->addFieldToTab('Root.GlobalMetadata', new TextareaField('MetaDescription', _t('SiteConfig.MetaDescription', 'Description')));
			$fields->addFieldToTab('Root.GlobalMetadata', new TextareaField('ExtraMeta', _t('SiteConfig.ExtraMeta', 'Custom Meta Tags')));
			
			return $fields;
		}
		
	}

?>