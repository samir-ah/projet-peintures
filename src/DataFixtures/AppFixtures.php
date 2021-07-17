<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Painting;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $encoder)
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        //user
        $user = new User();
        $user->setEmail('user@test.com')
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setPhone($faker->phoneNumber())
            ->setAbout($faker->text())
            ->setInstagram('instagram');
        $password = $this->encoder->hashPassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);


        //blogpost
        for ($i = 0; $i < 10; $i++) {
            $blogpost = new BlogPost();
            $blogpost->setTitle($faker->words(3, true))
                ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                ->setContent($faker->text(350))
                ->setSlug($faker->slug(3))
                ->setUser($user);
            $manager->persist($blogpost);
        }

        //categories
        for ($c = 0; $c < 5; $c++) {
            $category = new Category();
            $category->setName($faker->words(2, true))
                ->setDescription($faker->words(10, true))
                ->setSlug($faker->slug());
            $manager->persist($category);
            // 2 painting / Category
            for ($p = 0; $p < 2; $p++) {
                $painting = new Painting();
                $painting->setWidth($faker->randomFloat(2, 20, 60))
                    ->setHeight($faker->randomFloat(2, 20, 60))
                    ->setName($faker->words(3, true))
                    ->setDescription($faker->text())
                    ->setPortfolio($faker->randomElement([true, false]))
                    ->setOnSale($faker->randomElement([true, false]))
                    ->setFile('/img/portfolio/fullsize/' . $faker->numberBetween(1, 6) . '.jpg')
                    ->setPrice($faker->randomFloat(2, 100, 10000))
                    ->setSlug($faker->slug())
                    ->setUser($user)
                    ->addCategory($category)
                    ->setCompletionDate($faker->dateTimeBetween('-6 month', 'now'))
                    ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));

                $manager->persist($painting);
            }
        }

        $manager->flush();
    }
}
