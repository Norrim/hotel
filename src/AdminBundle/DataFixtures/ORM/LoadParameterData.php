<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use AdminBundle\Entity\Parameter;
use AdminBundle\Entity\ParameterTranslation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadParameterData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $parameter = new Parameter();

        $translation = new ParameterTranslation();
        $translation->setLocale('fr');
        $translation->setName('Téléphone');
        $translation->setContent('06.24.14.84.89');

        $translation2 = new ParameterTranslation();
        $translation2->setLocale('en');
        $translation2->setName('Phone');
        $translation2->setContent('+33 6.24.14.84.89');

        $parameter->addTranslation($translation);
        $parameter->addTranslation($translation2);

        $manager->persist($parameter);
        $manager->flush();
    }

    public function getOrder()
    {
        return 100;
    }
}
