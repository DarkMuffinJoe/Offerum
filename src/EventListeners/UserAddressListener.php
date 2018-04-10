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

        $data = json_decode($entity->getAddress(), true);
        $address = new Address();

        $address->street = $data['street'];
        $address->city = $data['city'];
        $address->postalCode = $data['postalCode'];
        $address->country = $data['country'];

        $entity->setAddress($address);
    }

    protected function upload($entity)
    {
        if (!$entity instanceof User) {
            return;
        }

        $address = $entity->getAddress();

        if ($address instanceof Address) {
            $data = [
                'street' => $entity->getAddress()->street,
                'city' => $entity->getAddress()->city,
                'postalCode' => $entity->getAddress()->postalCode,
                'country' => $entity->getAddress()->country
            ];

            $entity->setAddress(json_encode($data));
        }
    }
}
