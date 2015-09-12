<?php
    require $sc->rootURL.'/inc/scss.inc.php'; 
    $scss = new scssc();
    $scss->setFormatter("scss_formatter_compressed");
    $directory = $sc->rootURL."/template/css";
    scss_server::serveFrom($directory);
