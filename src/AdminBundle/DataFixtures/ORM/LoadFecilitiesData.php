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
        $content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac velit justo. Mauris vitae nisl felis. Vestibulum vel sem rutrum, malesuada mauris sit amet, tempus lacus. Ut consectetur, sapien vitae lobortis pharetra, neque massa bibendum ipsum, sit amet venenatis ex urna luctus neque. Fusce vel faucibus elit, eu molestie mauris. Nam urna erat, condimentum eget sollicitudin eu, imperdiet porta nisi. Donec lacus ex, malesuada sit amet massa ut, aliquam malesuada nibh. Fusce molestie placerat nisi, at ornare elit imperdiet vel. Maecenas rutrum mauris molestie tempus tempus. In hac habitasse platea dictumst.</p>";

        $fecilities = new Fecilities(true);
        $fecilities->setIcon('bed');

        $translationFr = new FecilitiesTranslation();
        $translationFr->setLocale('fr');
        $translationFr->setName('Lits Grande Taille');
        $translationFr->setContent($content);

        $translationEn = new FecilitiesTranslation();
        $translationEn->setLocale('en');
        $translationEn->setName('Beds king size');
        $translationEn->setContent($content);

        $fecilities->addTranslation($translationFr);
        $fecilities->addTranslation($translationEn);

        $fecilities2 = new Fecilities(true);
        $fecilities2->setIcon('phone');

        $translationFr2 = new FecilitiesTranslation();
        $translationFr2->setLocale('fr');
        $translationFr2->setName('Réveil téléphonique');
        $translationFr2->setContent($content);

        $translationEn2 = new FecilitiesTranslation();
        $translationEn2->setLocale('en');
        $translationEn2->setName('Wake-up call');
        $translationEn2->setContent($content);

        $fecilities2->addTranslation($translationFr2);
        $fecilities2->addTranslation($translationEn2);

        $fecilities3 = new Fecilities(true);
        $fecilities3->setIcon('coffee');

        $translationFr3 = new FecilitiesTranslation();
        $translationFr3->setLocale('fr');
        $translationFr3->setName('Café et thé');
        $translationFr3->setContent($content);

        $translationEn3 = new FecilitiesTranslation();
        $translationEn3->setLocale('en');
        $translationEn3->setName('Coffee and tea');
        $translationEn3->setContent($content);

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
