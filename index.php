<?php
/**
 * 2014 - Unifr.ch
 * -----------------------------------------------------------------------------
 * author       Luca Carnevale <luca.carnevale@unifr.ch>
 * inspiration  Caroline Liu <hello@superchlorine.com>
 * version      v   0.0.1.0
 * git repo     http://svx-uo1151repo.unifr.ch/weboffice/singlepage.git
 * version log  http://svx-uo1151repo.unifr.ch/weboffice/singlepage/vlog.md
 */
/**
 * Loads HTML data from an XML file 'sample.xml' and displays it in a
 * form for editing. On submit (via post), saves the updated HTML data
 * back into 'sample.xml'.
 */
ini_set('display_errors', '-1');

// Load XML data from file into a SimpleXMLElement.
$xml = simplexml_load_file('sample.xml');

// Get the text from the 'content' child node and escape it. 
foreach ($xml->children() as $c) {
    $html[$c->getName()] = html_entity_decode($c, ENT_COMPAT | ENT_XHTML, 'UTF-8');
}
?>

<html>

    <head>
        <title><?php echo $html['title']; ?></title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

        <style>
            body    {   padding-top:0px;}
            footer .container .row{ border-top:#333 solid 1px; }
            footer .container .row{ padding-top:1.61em; margin-top:1.61em; }
            .info-sup   {   padding-top:3.41em;}
            .up{    font-size:0.61em; color:#333; padding-left:.61em;}
        </style>
    </head>

    <body>

        <?php

        function callback($buffer) {
            return (str_replace('contenteditable="true"', '', $buffer));
        }

        ob_start("callback");
        include 'template.php';
        ob_end_flush();
        //include('template.php');
        ?>

        <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script>
            var target = $(".menu").html();

            var ToC = "";

            var newLine, el, title, link;

            $("#" + target + "> h2").each(function (index) {
                $(this).attr('id', 'ct-' + index);
                el = $(this);
                title = el.text();
                link = "#" + el.attr("id");
                newLine =
                        "<li>" +
                        "<a href='" + link + "'>" +
                        title +
                        "</a>" +
                        "</li>";
                ToC += newLine;
                el.html(el.text()+' <small><span class="glyphicon glyphicon-chevron-up up"></span></small>');
            });
            $(".menu").html(ToC);
        </script>
        <script type = "text/javascript" >
            $(function () {
                $('.up').click(function () {
                    $('body,html').animate({scrollTop: 0}, 500);
                });
            });
        </script>

    </body>
</html>
