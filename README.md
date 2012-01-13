# Plain Response

a simple responsive theme for Drupal 7 (with a few neat twists)

by Geoffrey Roberts  
g.roberts@blackicemedia.com

## About this theme

This theme was created as a demonstration for my Drupal Downunder 2012 presentation 
on Responsive Design.

Slides are up at http://blackicemedia.com/presentations/jan2012-responsive

The license for this theme (GPL version 2) is included at the end of this document.

### External Components

This theme uses the following external components:

**Tiny Fluid Grid**  
http://tinyfluidgrid.com/  
created by Girlfriend NYC (http://www.girlfriendnyc.com/)  
License: CC BY-SA 3.0

**Respond Shim**  
https://github.com/scottjehl/Respond  
created by Scott Jehl (http://scottjehl.com/)  
See lib/Respond/README.md for instructions on implementing CND/cross-site proxying support.  
License: MIT / GPL2

**HTML5 Shim**  
http://code.google.com/p/html5shim/  
License: MIT / GPL2

## Installation

Install this theme as you would any other Drupal theme.  
http://drupal.org/documentation/install/modules-themes

To enable image styles for flexible images, go to the theme's Settings page and 
click the _Add Custom Image Styles_ button.  The image styles that are provided out of 
the box can be modified once they have been created, or saved as part of a Feature.

To disable image styles, go to the theme's Settings page and 
click the _Remove Custom Image Styles_ button.  The image styles can be re-created, but 
they will not have any custom changes you made.

## Implementation Details

### Theme-Specific Image Styles

This theme relies on custom image style being enabled.

The **theme-settings.php** file stores some custom form alterations for the theme settings 
form that creates image styles from presets when a button is clicked, and can disable them 
again when another button is clicked.

By default, the image styles scale the images to a given width, and don't allow upscaling 
to ensure that smaller images are loaded at their largest size.  (The images will be scaled 
by percentage later.)

### Flexible Images

This component allows images to be loaded at different resolutions depending on the 
size of the browser window.

There is a theme override for __theme_image_style__ that adds a custom, non-standard 
variable called **originalsrc** to the img tags that specifies Drupal's internal path 
to the file (eg. public://whatever.jpg).

A JavaScript implementation of the Drupal API's 
[_image_styles_url_](http://api.drupal.org/api/drupal/modules--image--image.module/function/image_style_url/7) 
function generates URLs from an image style name and an image's originalsrc attribute. 
The resulting URL points to versions of an image that have been converted to 
a particular image style.  The image's src variable is then changed to the new image, and 
the new image is dynamically loaded.

By default, the smallest image style is used to ensure that mobile devices are served the 
lowest bandwidth images by default.

This function is called whenever the browser is resized, so any images with an originalsrc 
variable are dynamically reloaded.  Same happens when the page is loaded.

## License

Plain Response: a simple responsive theme for Drupal 7
Copyright © 2012 Geoffrey Roberts

This program is free software; you can redistribute it and/or  
modify it under the terms of the GNU General Public License  
as published by the Free Software Foundation; either version 2  
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,  
but WITHOUT ANY WARRANTY; without even the implied warranty of  
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the  
GNU General Public License for more details.

You should have received a copy of the GNU General Public License  
along with this program; if not, write to the Free Software  
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

----------------------------

(See the included LICENSE.txt for the full license.)

