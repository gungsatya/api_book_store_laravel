<?php

namespace App\Helpers\Routes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper
{
    public static function includeRouteFiles(string $folder): void
    {
        $dirIterator = new RecursiveDirectoryIterator($folder);

        /** @var RecursiveDirectoryIterator | RecursiveIteratorIterator $iterator * */
        $iterator = new RecursiveIteratorIterator($dirIterator);

        // require the file in each iterator
        while ($iterator->valid()) {

            if (!$iterator->isDot()
                && $iterator->isFile()
                && $iterator->isReadable()
                && $iterator->current()->getExtension() == 'php') {

                require $iterator->key();
            }


            $iterator->next();
        }
    }
}
