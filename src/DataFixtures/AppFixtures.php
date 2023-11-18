<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bieres = [
            ['Chocolate IPA','chocolate.jpg'],
            ['Coquatrice IPA','coquatrice.jpg'],
            ['Deus','deus.png'],
            ['Fleur de bière','fleur-de-biere-fut-de-chene.jpg'],
            ['Imperial Stout','imperial-stout-barriquee-vieillie-en-fut-de-maury-magnum.png'],
            ['Les deux amants IPA.','les-deux-amants-ipa.webp'],
            ['Penguins','penguins.jpg'],
            ['Saint Bon-chien','saint-bon-chien.jpg'],
            ['Septante Neuf','septante-neuf.jpg'],
        ];
        $priceInCent = 1000;
        foreach($bieres as $biere){
            $product = new Product();
            $product->setTitle($biere[0]);
            $product->setImagePath($biere[1]);
            $product->setShortDescription('Lorem hicsum and dolore si amère...');
            $product->setPriceInCents($priceInCent);
            $priceInCent+= 120;
            $manager->persist($product);
        }

        $manager->flush();
    }
}
