=== Plugin Name ===
Contributors: daif
Donate link: http://smsgw.net/
Tags: sms, mobile, phone, send , message, groups, contacts
Requires at least: 3.0.1
Tested up to: 4.5.2
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send SMS using smsgw.net or any other providers.

== Description ==

Send SMS using [SMSgw.net](http://smsgw.net/) as main provider and others providers like [Mobily.ws](http://mobily.ws/), [4jawaly.net](http://4jawaly.net/), [Malath.net.sa](http://malath.net.sa/), [Resalty.net](http://resalty.net/) and [AshharSMS.com](http://ashharsms.com).


== Installation ==

Follow these steps:

1. Upload `smsgw` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Who are the SMS gateways that are supported by this plug-in? =

1. [SMSgw.net](http://smsgw.net/)
2. [Mobily.ws](http://mobily.ws/)
3. [4jawaly.net](http://4jawaly.net/)
4. [Malath.net.sa](http://malath.net.sa/)
5. [Resalty.net](http://resalty.net/)
6. [AshharSMS.com](http://ashharsms.com)


= How to support new service provider? =

Add new php class in `smsgw/includes/providers` folder and implement ProviderInterface.


== Upgrade Notice ==

N/A

== Screenshots ==

1. Admin - Send SMS
2. Admin - Messages
3. Admin - Control Contacts
4. Admin - Control Groups
5. Admin - Configurations

== Changelog ==

= 1.0 =
* first release.
