<?php

namespace Offerum\EventListeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Offerum\Entity\Offer;
use Offerum\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OfferImageUploadListener
{
    private $uploader;
    private $subDirectory;

    public function __construct(FileUploader $uploader, string $subDirectory)
    {
        $this->uploader = $uploader;
        $this->subDirectory = $subDirectory;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->upload($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->upload($entity);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Offer) {
            return;
        }

        $fileName = $entity->getImage();

        if ($fileName) {
            $entity->setImage(new File($this->uploader->getUploadDirectory() . '/' . $this->subDirectory . '/' . $fileName));
        }
    }

    public function upload($entity)
    {
        if (!$entity instanceof Offer) {
            return;
        }

        $file = $entity->getImage();

        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file, $this->subDirectory);
            $entity->setImage($fileName);
        }
        elseif ($file instanceof File) {
            $fileName = $file->getBasename();
            $entity->setImage($fileName);
        }
    }
}