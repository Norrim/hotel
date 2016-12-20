<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use AdminBundle\Entity\Fecilities;
use AdminBundle\Entity\FecilitiesTranslation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFecilitiesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fecilities = new Fecilities();
        $fecilities->setIcon('fa fa-bed');

        $translationFr = new FecilitiesTranslation();
        $translationFr->setLocale('fr');
        $translationFr->setName('Lits Grande Taille');

        $translationEn = new FecilitiesTranslation();
        $translationEn->setLocale('en');
        $translationEn->setName('Beds king size');

        $fecilities->addTranslation($translationFr);
        $fecilities->addTranslation($translationEn);

        $fecilities2 = new Fecilities();
        $fecilities2->setIcon('fa fa-phone');

        $translationFr2 = new FecilitiesTranslation();
        $translationFr2->setLocale('fr');
        $translationFr2->setName('Réveil téléphonique');

        $translationEn2 = new FecilitiesTranslation();
        $translationEn2->setLocale('en');
        $translationEn2->setName('Wake-up call');

        $fecilities2->addTranslation($translationFr2);
        $fecilities2->addTranslation($translationEn2);

        $fecilities3 = new Fecilities();
        $fecilities3->setIcon('fa fa-coffee');

        $translationFr3 = new FecilitiesTranslation();
        $translationFr3->setLocale('fr');
        $translationFr3->setName('Café et thé');

        $translationEn3 = new FecilitiesTranslation();
        $translationEn3->setLocale('en');
        $translationEn3->setName('Coffee and tea');

        $fecilities3->addTranslation($translationFr3);
        $fecilities3->addTranslation($translationEn3);
        

        $manager->persist($fecilities);
        $manager->persist($fecilities2);
        $manager->persist($fecilities3);
        $manager->flush();

        $this->addReference('fecilities-1', $fecilities);
        $this->addReference('fecilities-2', $fecilities2);
        $this->addReference('fecilities-3', $fecilities3);
    }

    public function getOrder()
    {
        return 1;
    }
}
