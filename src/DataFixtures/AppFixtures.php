<?php

namespace App\DataFixtures;

use App\Entity\Command;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    /**
     * Encodeur de mot de passe
     *
     * @param UserPasswordEncoderInterface $encoder
     */

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create("fr_FR");
        for ($u = 0; $u < 30; $u++) {
            $user = new User;
            // $hash = $this->encoder->encodePassword($user, "password");
            $user->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword("password",$this->encoder);
            
            // $command = new Command;
            // $command->setAdress($faker->address)
            //         ->setZipcode($faker->address)
            //         ->setUser($user)
            //         ->setPrice
            //         ->setDate($faker->date())
            //         ->setStatus(($command->getGenres()[mt_rand(0,3)]))
                    

            $manager->persist($user);
        }
        for ($u = 0; $u < 20; $u++) {
            $product = new Product;
            $product->setName($faker->word())
                ->setPhoto($faker->url)
                ->setDescription($faker->text)
                ->setPrice($faker->randomNumber(2))
                ->setQuantity($faker->randomDigit());
            $manager->persist($product);

            
        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
