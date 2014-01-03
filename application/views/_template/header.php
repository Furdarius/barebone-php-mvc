<!DOCTYPE HTML>
<html>
    <head>
        <title><?=$TITLE?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?=$SITE_DESCRIPTION?>" />
        <meta name="keywords" content="<?=$SITE_KEYWORDS?>" />

        <link href="/application/public/css/style.css" rel="stylesheet">

        <!-- Page custom Styles -->
        <?php
            foreach ($this->getStyles() as $style) 
                echo '<link href="' . $style . '" rel="stylesheet">' . "\n";
        ?>

        <!-- Page custom Scripts -->
        <?php
            foreach ($this->getScripts() as $script) 
                echo '<script src="' . $script . '"></script>' . "\n";
        ?>

    </head>
    <body>
        <div class="container">
            <div class="header">
                This is Header
            </div>