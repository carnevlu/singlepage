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
$msg = array();

if (isset($_POST) && count($_POST) > 0) {

    // Get text from the editor and escape it.
    // I'm using htmlspecialchars for backwards compatibility.
    // Use the newer filter_var if you can.
    foreach ($_POST as $k => $v) {
        $html[$k] = htmlentities($_POST[$k], ENT_COMPAT | ENT_XML1, 'UTF-8');
        //$html[$k] = filter_input(INPUT_POST, $k, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    // Make a new SimpleXMLElement with 'article' as the root node.
    $node = new SimpleXMLElement('<article></article>');

    // Add a 'content' child node to 'article'. This holds all our html data.
    foreach ($html as $k => $v) {
        $node->addChild($k, $v);
    }

    // Export the node to an XML string.
    //  $xml = $node->asXML();
    // Write the XML string to file. file_put_contents('sample.xml', utf8_encode($xml))
    if ($node->asXML('sample.xml')) {
        $msg[] = array("success", "Change saved");
    } else {
        $msg[] = array("danger", "Change not saved");
    }

    //generate the sitemap
    $sitemap = new SimpleXMLElement('
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>http://' . $_SERVER['HTTP_HOST'] . str_replace('edit.php', 'index.php', $_SERVER['PHP_SELF']) . '</loc>
        <lastmod>' . date("Y-m-d") . '</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1</priority>
    </url>
</urlset>');
    $sitemap->asXML('sitemap.xml');
    unset($html);
}

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

        <script src="//cdn.ckeditor.com/4.4.6/standard/ckeditor.js" charset="utf-8"></script>

        <style>
            body    {   padding-top:70px;}
            footer .container .row{ border-top:#333 solid 1px; }
            footer .container .row{   padding-top:1.61em; margin-top:1.61em; }
            .info-sup   {   padding-top:3.41em;}
        </style>
    </head>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5"><p class="navbar-text">Edit mode</p></div>
                    <div class="col-sm-3">
                        <p class="navbar-text">
                            <?php
                            //  print the message of the CMS
                            foreach ($msg as $m)
                                echo '<span class="label label-' . $m[0] . '">' . $m[1] . '</span> ';
                            ?>
                        </p>
                    </div>
                    <div class="col-sm-1 col-sm-offset-2">
                        <button type="button" class="btn navbar-btn btn-success navbar-right" id="save">Save</button>
                    </div>
                    <div class="col-sm-1 ">
                        <a href="index.php">
                            <button type="button" class="btn navbar-btn btn-danger navbar-right" id="exit">Close</button>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <?php
        //  apply the template
        include('template.php');
        ?>

        <form action="edit.php" method="POST" id="magicform"></form>

        <script>
            // Active CKEditor inline on all element editable with his config
            CKEDITOR.editorConfig = function (config) {
                config.language = 'fr';
                config.entities = false;
                config.entities_latin = false;
                config.uiColor = '#AADC6E';
                config.extraAllowedContent = 'noscript script[*], ';
            };
        </script>
        <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#save').click(function () {
                $("[contenteditable='true']").each(function (index) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'i-' + this.id,
                        name: this.id
                    }).val($(this).html()).appendTo('#magicform');
                });
                $('#magicform').submit();
            });
        </script>

    </body>
</html>
