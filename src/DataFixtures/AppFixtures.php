<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        
        #create 20 users
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $faker = Faker\Factory::create('fr_FR');

            $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));

            $user->setLastName($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword('azerty');
            $user->setIsActive($faker->boolean($chanceOfGettingTrue = 50));
            

            if ($i==0) {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            };

            $manager->persist($user);
        }

        $manager->flush();
    }
}
