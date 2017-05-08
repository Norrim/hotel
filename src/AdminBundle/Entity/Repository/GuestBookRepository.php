<?php

namespace AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class GuestBookRepository extends EntityRepository
{
    public function findAllOrderDesc()
    {
        return $this->findBy([], ['id' => 'DESC']);
    }

    public function findValidatedOrderDesc()
    {
        return $this->findBy(['isValidated'=> true], ['id' => 'DESC']);
    }
}
