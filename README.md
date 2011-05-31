# NeoSEO

I wrote NeoSEO to eliminate some of the more tedious end-of-project concerns
such as configuring analytics and metadata. SEO is an extremely important part
of website development these days but is essentially just data entry. I hope my
little contribution to the SilverStripe community makes someone's life just a
tiny bit easier!

## Requirements

SilverStripe 2.4.0+

## Installation

1) Unpack the NeoSEO directory to the root of your SilverStripe install.
2) Ensure the directory is named 'neoseo'. Case is important on *NIX.
3) Browse to: http://<silverstripe-install-url>/dev/build?flush=all

You can now configure most of NeoSEO via the "Search Engine Optimization" panel
under your website configuration in SilverStripe's admin interface.

## Features

Some of NeoSEO's current features include:
  - Global metadata configuration
  - Keyword suggestion, with configurable options for exclusion, quantity, etc
  - Page-by-page options to append global metadata, with extended paramaters
    when applicable.
  - Support for Google Analytics, and Yahoo! Web Analytics.
  - Advanced variable support for Yahoo! Web Analytics.

## Templates

No modification is required to most templates. The only exception is when you
have removed $MetaTags from the head of a template. The rest of this section
applies only to users who have removed $MetaTags from their template. I really
do recommend that you consider using $MetaTags rather than processing them
manually - so much easier!

The following variables are available to templates:

  [Metadata]
	
  $AppendMetaKeywords           (boolean) Append global data?
  $MetaKeywords                 (string) Page's meta keywords
  $SiteConfig.MetaKeywords      (string) Global meta keywords
  
  $AppendMetaDescription        (string) Append meta description?
                                (option) 'Beginning' = append to beginning
                                (option) 'End' = append to end
                                (option) 'No' = do not append
  $MetaDescription              (string) Page's meta description
  $SiteConfig.MetaDescription   (string) Global meta description
  
  $AppendExtraMeta              (boolean) Append extra meta tags?
  $ExtraMeta                    (string) Page's extra meta tags
  $SiteConfig.ExtraMeta         (string Global extra meta tags
  
  [General information about analytics]

  You will need to include all of the tracker JavaScript in the template as it
  will not be supplied by any template variable. This is not true if you are
  using $MetaTags in your template, however.
  
  [Analytics - Google]
  
  $SiteConfig.AnalyticsGoogleEnabled
                                (boolean) Google Analytics enabled?
  $SiteConfig.AnalyticsGoogleAccountNumber
                                (string) Google Analytics account number

  [Analytics - Yahoo!]
  
  $SiteConfig.AnalyticsYahooEnabled
                                (boolean) Yahoo! Web Analytics enabled?
  $SiteConfig.AnalyticsYahooTrackingId
                                (string) Yahoo! Web Analytics tracking Id
  $SiteConfig.YahooAnalyticsVariables
                                (control) Array of variables for YWA
                                  (string) $Name
                                  (string) $Value

## Credits

Developer(s):
  Christopher H. Allen
    <chris (at) llen (dot) co (dot) nz>

Other(s):
  Peter Nilsson (MetaManager)
    <peter (at) kreationsbyran (dot) se>
  Juanitou (MetaManager)
    <unknown>
  Martijn van Nieuwenhoven (MetaManager)
    <marvanni (at) hotmail (dot) com>
