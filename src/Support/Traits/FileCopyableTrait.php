<?php

namespace Lexxsoft\Upbasis\Support\Traits;

trait FileCopyableTrait
{
    private static function copyFiles($src, $dst): void
    {
        // open the source directory
        $dir = opendir($src);

        // Make the destination directory if not exist
        if (!file_exists($dst)) {
            mkdir($dst);
        }

        // Loop through the files in source directory
        foreach (scandir($src) as $file) {

            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . DIRECTORY_SEPARATOR . $file)) {

                    // Recursively calling custom copy function
                    // for sub directory
                    self::copyFiles($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);

                } else {
                    copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
                }
            }
        }

        closedir($dir);
    }
}
