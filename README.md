Simple Single Page by unicom
============================

>This software offer a easy way to produce a basic singlepage website

## Features
This mini web application offers:

1.  Real Visual Edition of the content
2.  Easy templating
3.  Auto-generation of the menu
4.  Integration of
    1.  Jquery
    2.  Bootstrap
    3.  CKEditor (the WYSIWYG)
5.  NO SQL database
6.  `sitemap.xml` and `robot.txt` ready to use

## Installation
There are 1 and half steps to install this software:

1.  copy all the contents of `singlepage/*` in the `root/*` of the server;

If something don't work check the permission of the file `sample.xml` and `edit.php` to `775`.

## Personalization
### Templating
Editing the file `template.php` you can change the visualization of your page.

For each tag editable you should specify some data:

-   a `id="id_of_the_tag" `
-   the attribute `contenteditable` to `true`
-   and the output of the variable `$html['id_of_the_tag']`

#### Example
```php
<div id="content" contenteditable="true">
    <?php echo $html['content']; ?>
</div>
```
#### The auto generated menu
The application offer a auto generate menu. You should place in the  `template.php` file a ul tag with the class="menu". The ul should contain the id of the sible div (the editable div). For each h2 in the sible will be generate a entry in the menu. 

The menu is only active in the view mode.

##### Example
```php
<ul class="nav nav-pills nav-stacked menu">content</ul>
```

## Advanced settings
You can edit the CDK configuration in edit.php to use other package by [cdn.ckeditor.com](https://cdn.ckeditor.com).

And at the same time you can specify the plug-in to load or disable for advanced configuration.

## Know Issuses
The list:
-   #1 writing HTML the code will generate undefined behavior.
