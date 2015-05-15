=== Parsnip ===
Contributors: zingiri
Donate link: http://www.zingiri.com/donations
Tags: parse, parser, snippet, html
Requires at least: 3.4
Tested up to: 4.2.2
Stable tag: 1.0.1
License: GPLv2 or later

Include HTML snippets from other sites in your own site

== Description ==

This plugin allows you to parse HTML snippets from other websites in your own site. 

This is useful if you have for example a FAQ running on one of your systems and want to display the content in your Wordpress website.

== Installation ==

1. Upload the `parsnip` folder to the `/wp-content/plugins/` directory or install via the Wordpress plugins menu.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use [parsnip] short codes as explained in the FAQ section.

== Frequently Asked Questions ==

There is no general configuration, the plugin works simply with short codes.
In the following example we will demonstrate how to parse a FAQ section of our own FAQ running on WHMCS into our Wordpress site.

You can use shortcodes in the following format:

[parsnip level="..." url="..." pre="..." selectors="..." nofollow="1"]

* url: the URL you want to get a HTML snippet from, for example "http://go.zingiri.com/knowledgebase/1019/Bookings"
* pre: the first part of the URL "http://go.zingiri.com"
* selectors: the jQuery style selectors to retrieve the portion of the HTML page that we want, for example ".contentpadded .row". They can be comma separated in case you want to use multiple selections on the page. We use the [phpQuery](http://code.google.com/p/phpquery/ "phpQuery") library for this, you will find more example on their site.
* level: parsing level, we'll come to this later
* nofollow: specifying nofollow="1" will disable any links on the page you are retrieving

So this would give:

[parsnip url="http://go.zingiri.com/knowledgebase/1019/Bookings" pre="http://go.zingiri.com/" selectors=".contentpadded .row"]

And this would display all the FAQ's for our Bookings plugin.

Now we want to go a step further and be able to follow the links as well, for this we will use the 'level' attribute.

[parsnip level="2" url="http://go.zingiri.com/knowledgebase/1019/Bookings" pre="http://go.zingiri.com/" selectors=".contentpadded h2,.contentpadded blockquote"]

Note that both [parsnip] short codes go together on the page like this:

[parsnip url="http://go.zingiri.com/knowledgebase/1019/Bookings" pre="http://go.zingiri.com/" selectors=".contentpadded .row"]
[parsnip level="2" url="http://go.zingiri.com/knowledgebase/1019/Bookings" pre="http://go.zingiri.com/" selectors=".contentpadded h2,.contentpadded blockquote"]

You will now be able to view the Bookings FAQs and also to open individual links. 

You can also set level="*" in which case the same selectors are used on all pages.

== Screenshots ==

1. First level parsing example
2. Second level parsing example, following the links here above
3. Example short code set-up

== Upgrade Notice ==
Standard plugin upgrade method applies.

== Changelog ==

= 1.0.1 =
* Verified compatibility with Wordpress 4.2.2
* Fixed issue with parsing of links
* Added new "nofollow" option

= 1.0.0 =
* First release

