<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Client;
use App\Entity\Showroom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\Fakecar;
use Nelmio\Alice\Loader\NativeLoader;
use Nelmio\Alice\Throwable\LoadingThrowable;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @throws LoadingThrowable
     */
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();

        $loader->getFakerGenerator()->addProvider(new Fakecar($loader->getFakerGenerator()));

        $objectSet = $loader->loadData([
            Car::class => [
                'car{1..200}' => [
                    '__construct' => ['<vehicleBrand()>', '<vehicleModel()>', '<regexify("[A-F]")>'],
                ],
            ],
            Client::class => [
                'client{1..100}' => [
                    '__construct' => ['<lastName()>', '<firstName()>'],
                ],
            ],
            Showroom::class => [
                'showroom{1..150}' => [
                    '__construct' => [
                        '@car<current()>',
                        '<randomDigit()>',
                        '<numberBetween(1000000, 100000000)>',
                        '<currencyCode()>'
                    ],
                ],
            ],
        ]);

        foreach ($objectSet->getObjects() as $carInShowroom) {
            $manager->persist($carInShowroom);
        }

        $manager->flush();
    }
}
