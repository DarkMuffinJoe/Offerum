<?php

namespace Offerum\EventListeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Offerum\Entity\Address;
use Offerum\Entity\User;

class UserAddressListener
{
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

        if (!$entity instanceof User) {
            return;
        }

        $addressElements = explode(';', $entity->getAddress());
        $address = new Address();

        $address->street = $addressElements[0];
        $address->city = $addressElements[1];
        $address->postalCode = $addressElements[2];
        $address->country = $addressElements[3];

        $entity->setAddress($address);
    }

    protected function upload($entity)
    {
        if (!$entity instanceof User) {
            return;
        }

        $address = $entity->getAddress();

        if ($address instanceof Address) {
            $entity->setAddress($address->street . ';' . $address->city . ';' . $address->postalCode . ';' . $address->country);
        }
    }
}
