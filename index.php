<?php

require_once 'engine/init.php';

/**
 * inicjalizacja aplikacji
 */
try {
    new init();
} catch (Exception $ex) {
    echo $ex->getMessage();
}


