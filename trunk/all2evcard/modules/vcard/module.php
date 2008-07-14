<?php

$Module = array( 'name' => 'vcard' );

$ViewList = array();
$ViewList['export'] = array( 'script' => 'export.php',
                             'functions' => array( 'export' ),
                             'params' => array( 'Class', 'NodeID' ) );

$FunctionList = array();
$FunctionList['export'] = array();

?>