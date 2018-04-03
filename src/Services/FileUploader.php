<?php

namespace Offerum\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    /**
     * @param UploadedFile $file
     * @param string $subDirectory
     * @return string
     */
    public function upload(UploadedFile $file, string $subDirectory)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->uploadDirectory . '/' . $subDirectory, $fileName);

        return $fileName;
    }

    /**
     * @return string
     */
    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }
}