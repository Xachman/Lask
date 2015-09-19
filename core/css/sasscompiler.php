<?php
    require $sc->rootURL.'core/inc/scss.inc.php';
    $scss = new scssc();
    //$scss->setFormatter("scss_formatter_compressed");
    if(file_exists($sc->rootURL."template/css/sass.scss")){
      $directory = $sc->rootURL."template/css/";
    }else{
      $directory = $sc->rootURL."core/css/";
    }
    //var_dump($_GET['p']);
    scss_server::serveFrom($directory);
    // $server = new scss_server($directory, null, $scss);
    // $server->serve();
