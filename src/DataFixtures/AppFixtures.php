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

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
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
            ->setInstagram('instagram')
            ->setRoles(['ROLE_PEINTRE']);
        $password = $this->encoder->hashPassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);


        //blogpost
        for ($i = 0; $i < 100; $i++) {
            $blogpost = new BlogPost();
            $blogpost->setTitle((string)$faker->words(3, true))
                ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                ->setContent($faker->text(350))
                ->setSlug($faker->slug(3))
                ->setUser($user);
            $manager->persist($blogpost);
        }

        //Création d'un blogpost pour les tests
        $blogpost = new BlogPost();
        $blogpost->setTitle('Blogpost test')
            ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
            ->setContent($faker->text(350))
            ->setSlug('blogpost-test')
            ->setUser($user);
        $manager->persist($blogpost);

        //categories
        for ($c = 0; $c < 5; $c++) {
            $category = new Category();
            $category->setName((string)$faker->words(2, true))
                ->setDescription((string)$faker->words(10, true))
                ->setSlug($faker->slug());
            $manager->persist($category);
            // 2 painting / Category
            for ($p = 0; $p < 3; $p++) {
                $painting = new Painting();
                $painting->setWidth($faker->randomFloat(2, 20, 60))
                    ->setHeight($faker->randomFloat(2, 20, 60))
                    ->setName((string)$faker->words(3, true))
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
        //Categorie et peinture pour tests
        $category = new Category();
        $category->setName((string)$faker->words(2, true))
            ->setDescription((string)$faker->words(10, true))
            ->setSlug($faker->slug());
        $manager->persist($category);
        $painting = new Painting();
        $painting->setWidth($faker->randomFloat(2, 20, 60))
            ->setHeight($faker->randomFloat(2, 20, 60))
            ->setName('peinture test')
            ->setDescription($faker->text())
            ->setPortfolio($faker->randomElement([true, false]))
            ->setOnSale($faker->randomElement([true, false]))
            ->setFile('/img/portfolio/fullsize/' . $faker->numberBetween(1, 6) . '.jpg')
            ->setPrice($faker->randomFloat(2, 100, 10000))
            ->setSlug('peinture-test')
            ->setUser($user)
            ->addCategory($category)
            ->setCompletionDate($faker->dateTimeBetween('-6 month', 'now'))
            ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));

        $manager->persist($painting);

        $manager->flush();

    }
}
