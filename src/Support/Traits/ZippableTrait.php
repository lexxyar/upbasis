<?php

namespace Lexxsoft\Upbasis\Support\Traits;

use ZipArchive;

trait ZippableTrait
{
    /**
     * Zip a folder (include itself).
     * Usage:
     *   Instance::zipDir('/path/to/sourceDir', '/path/to/out.zip');
     *
     * @param string $sourcePath Path of directory to be zip.
     * @param string $outZipPath Path of output zip file.
     */
    private static function zipDir(string $sourcePath, string $outZipPath): void
    {
        $pathInfo = pathInfo($sourcePath);
        $parentPath = $pathInfo['dirname'];
        $dirName = $pathInfo['basename'];

        $z = new ZipArchive();
        $z->open($outZipPath, ZipArchive::CREATE);
        $z->addEmptyDir($dirName);
        self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
        $z->close();
    }

    /**
     * Add files and sub-directories in a folder to zip file.
     * @param string $folder
     * @param ZipArchive $zipFile
     * @param int $exclusiveLength Number of text to be exclusived from the file path.
     */
    private static function folderToZip(string $folder, ZipArchive &$zipFile, int $exclusiveLength): void
    {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = $folder . DIRECTORY_SEPARATOR . $f;

                // Remove prefix from file path before add to zip.
                $localPath = substr($filePath, $exclusiveLength);
                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {

                    // Add sub-directory.
                    $zipFile->addEmptyDir($localPath);
                    self::folderToZip($filePath, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

    /**
     * Unzip file
     * Usage:
     *      Instance::unzip('/path/to/file.zip', '/path/to/destination/folder');
     *
     * @param string $zipFilePath ZIP file path
     * @param string $destinationFolder Destination folder
     * @return bool
     */
    private function unzip(string $zipFilePath, string $destinationFolder): bool
    {
        $zip = new ZipArchive();
        $status = $zip->open($zipFilePath);
        if ($status !== true) {
            return false;
        }

        $zip->extractTo($destinationFolder);
        $zip->close();

        return true;
    }
}
