=== USGS River Data ===
Contributors: jtwiest
Donate link: http://jtwventures.com/projects/USGS
Tags: usgs, river, water level
Requires at least: 3.0
Tested up to: 3.7.1
Stable tag: 4.3

Enter the USGS Station ID and this plugin provides you with river name, currently water level, graph and station url via a widget or shortcode.

== Description ==

This plugin allows user to insert the USGS river data into their site in real time. By providing the plugin with the USGS ID number a widget or shortcodes can be generated to get the station name, current water level, water level graph and USGS link. 

Features: 
Display

* Widget 
* Shortcode (automatically generated using metabox)

Information Available:

* Station Name
* Current Water Level
* Current Gage Level in feet
* Water Level Graph
* Gage Height Graph
* Station Url
* Cache river information for a designated amount of time to speed up load time.

[Plugin's Official Documentation and Support Page](http://jtwventures.com/projects/USGS)

== Installation ==

1. Upload the unzipped contents of `usgs_river_data.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

[Full Support Page](http://jtwventures.com/projects/USGS)

Finding the USGS Station ID
There are two ways to find the data you can either use the USGS Station Finding Site or use google (google is much easier).

To Find on Google

1. Google “USGS Real-Time Water Data (Your Station)” where (Your Station) is the name of the station you want to find ie. Chagrin River.
1. Click the Link to the corresponding USGS site that display the current water level ex: http://waterdata.usgs.gov/oh/nwis/uv?04209000
1. Once you confirm this is the ccorrent site take the 8 diget code from the url just found and plug it into the plugin ie. 04209000 for the example above.
1. Your Done!

= What are the shortcodes I can use? =

Shortcode Cookbook
Note: # refers to the usgs id number

[river id='#']
Displays all of the information based on the configuration options set on the settings page.
See “Settings” -> “River Options” to change.

[river id='#' config='#']
Enter in the optional configuration number (1,2,3) to use one the the three options.

[river_name id='#']
Displays the name of the station.

[river_level id='#']
Displays the current water level of the station.

[river_gage id='#']
Displays the current gage height in feet.

[river_station id='#']
Displays the URL of the station.

[river_graph id='#']
Displays the url of the image graph.
Ex: <img src=”[river_graph id='#']” alt=”My River” width=”500px” />

[river_gage_graph id='#']
Displays the url of the gage height graph. 
Ex: <img src=”[river_graph id='#']” alt=”My River” width=”500px” />


== Screenshots ==

1. screenshot-1.png
1. screenshot-2.png
1. screenshot-3.png
1. screenshot-4.png

== Changelog ==

= 1.21 = 
*Minor variable change.

= 1.2 = 
*Added Cacheing capabilities for improved speeds on pages with multiple shortcodes.

= 1.12 = 
*Fixed bug where general output was being displayed above text.

= 1.11 = 
*Fixed minor bug, station graph would not display without gage graph.

= 1.10 =
Added Gage height and gage graph options to the plugin.
Fixed missing images on options page.
Corrected various links. 

= 1.01 =
* Fixed minor bug in river_data.php and river_custom_meta.php

= 1.0 =
* Launch

== Upgrade Notice ==

= 1.11 = 
Fixed minor bug, station graph would not display without gage graph.

= 1.10 =
Added Gage height and gage graph options to the plugin.
Fixed missing images on options page.
Corrected various links. 

= 1.01 =
Fixed minor bugs to update for wordpress 3.3.2.

= 1.0 =
This is the first version, has the ability to display all data in widget or shortcode form.