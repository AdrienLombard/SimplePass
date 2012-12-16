<?php

/*
 * FUNCTIONS
 */

function handleSecu()
{
    // php.ini content text
    $content = 'allow_url_fopen = On';
    
    // root file
    $ini = fopen(dirname(__FILE__) . '/php.ini', 'w+');
    fputs($ini, $content);
    fclose($ini);
    
    // browsing folders
    $iterator = new RecursiveDirectoryIterator(dirname(__FILE__));
    $directories = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
    foreach($directories as $dir)
    {
        if($dir->isDir())
        {
            $ini = fopen($dir . '/php.ini', 'w+');
            fputs($ini, $content);
            fclose($ini);
        }
    }
}

function dropSecu()
{
    // root file
    unlink(dirname(__FILE__) . '/php.ini');
    
    // browsing files
    $iterator = new RecursiveDirectoryIterator(dirname(__FILE__));
    $directories = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
    foreach($directories as $dir)
        unlink($dir . '/php.ini');
}


/*
 * EXECUTE
 */
handleSecu();

?>
