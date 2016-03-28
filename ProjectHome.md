Attempt to use the wordpress P2 Theme as a Page Template with a Custom Post Type

This is a work in progress. You can see it working at http://www.humbug.in/mblog/ (its **NOT** a demo page).

Check out the source code using the below command into your theme directory

```
cd THEME_DIRECTORY
svn checkout http://p2-theme-page-template.googlecode.com/svn/trunk/ p2
```

Add **`require_once( BIRDBRAIN_DIR . '/p2/p2-bridge.php' );`** at the bottom of your theme's function.php

Open up the `p2-bridge.php` file and edit the following variables according to your blog settings

```
$p2_custom_post_type = 'aside'; //Custom Post Type Identifier
$p2_custom_post_type_name = 'Asides'; //Custom Post Type Plural Name
$p2_custom_post_type_singular_name = 'Aside'; //Custom Post Type Singular Name
$p2_custom_post_type_page_slug = 'mblog'; //Page Slug where you want to display the P2 Blog
```

`p2-blog.php` - That is the page template being used on the blog right now, can be used as a sample to create your own.

`aside.php` - This is the custom post type template, i'm using the custom post type 'aside' and hence the template name is 'aside.php'. NOTE: Template naming rules are different for other themes, by default wordpress expects something like single-aside.php, however theme hybrid expects aside.php.

`p2/style.css` - Style Template used for the P2 blog specifically in addition to the theme's style.css

The Theme Directory Structure looks like

```
style.css
functions.php
aside.php
p2-blog.php
OTHER THEME FILES
p2/
p2/p2-bridge.php
p2/functions.php
p2/style.css
p2/entry.php
p2/js/p2.js
p2/OTHER P2 FILES
```


Also the files listed above the some of the important files that you might need to edit to get it work with your blog.