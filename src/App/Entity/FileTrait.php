<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;

trait FileTrait
{
    /**
     * Upload root directory path.
     * To be set by event listener to the configured path
     */
    protected $uploadRootDir;

    /**
     * Download root directory path
     * To be set by event listener to the configured path
     */
    protected $downloadRootDir;

    /**
     * Upload directory root url
     */
    protected $uploadRootUrl;

    /**
     * List of File(s) or absolute paths of files to be
     * deleted at the end
     */
    protected $trash = [];

    public function setUploadRootDir($path)
    {
        $this->uploadRootDir = $path;

        return $this;
    }

    public function getUploadRootDir()
    {
        if (!isset($this->uploadRootDir)) {
            throw new \RuntimeException('Upload root dir not set');
        }

        return $this->uploadRootDir;
    }

    public function setDownloadRootDir($path)
    {
        $this->downloadRootDir = $path;

        return $this;
    }

    public function getDownloadRootDir()
    {
        $fs = new Filesystem();
        if ($fs->exists($this->downloadRootDir)) {
            return $this->downloadRootDir;
        }

        return sys_get_temp_dir();
    }

    public function setUploadRootUrl($url)
    {
        $this->uploadRootUrl = $url;
    }

    public function getUploadRootUrl()
    {
        return $this->uploadRootUrl;
    }

    /**
     * Download file to download directory
     */
    protected function download(File $file, $name, $dir = null)
    {
        $targetPath = $this->getDownloadRootDir();
        if (strlen($dir) > 1) {
            $targetPath .= '/'.$dir;
        }
        $targetPath .= '/'.$name;

        $fs = new Filesystem();
        $fs->copy($file, $targetPath);

        return new File($targetPath);
    }

    /**
     * Move or copy in case of failure for example when
     * operating with stream wrapper
     */
    protected function upload(File $file, $name, $dir = null)
    {
        $uploadDir = $this->getUploadRootDir();
        if (strlen($dir) > 1) {
            $uploadDir .= '/'.$dir;
        }

        $targetPath = $uploadDir.'/'.$name;

        try {
            $file->move($uploadDir, $name);
        } catch (FileException $e) {
            $fs = new Filesystem();
            $fs->copy($file, $targetPath);
            $this->delete($file);
        }

        return new File($targetPath);
    }

    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * Add File(s) or paths to trash
     */
    protected function delete($file)
    {
        if (!in_array((string) $file, $this->trash)) {
            $this->trash[] = (string) $file;
        }
    }

    /**
     * Perform actual removal of files in trash
     */
    public function removeDeletedFiles()
    {
        $fs = new Filesystem();
        $fs->remove($this->getTrash());
        $this->trash = [];
    }

    /**
     * Reset delete list
     */
    public function emptyTrash()
    {
        $this->trash = [];
    }
}
