<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Painting;
use DateTime;
use PHPUnit\Framework\TestCase;

class PaintingTest extends TestCase
{
    public function testIsTrue(): void
    {

        $category = new Category();
        $category->setName('name')
            ->setDescription('description')
            ->setSlug('slug');

        $user = new User();
        $user->setEmail('true@test.test')
            ->setFirstName('firstname')
            ->setLastName('lastname')
            ->setAbout('about')
            ->setPassword('password')
            ->setInstagram('instagram');

        $painting = new Painting();
        $painting->setWidth(123, 00)
            ->setHeight(123, 00)
            ->setName('name')
            ->setDescription('description')
            ->setPortfolio('portfolio')
            ->setOnSale(true)
            ->setFile('file')
            ->setPrice(123, 00)
            ->setSlug('slug')
            ->setUser($user)
            ->addCategory($category)
            ->setCompletionDate(new DateTime())
            ->setCreatedAt(new DateTime());

        $this->assertTrue($painting->getName() === 'name');
        $this->assertTrue($painting->getDescription() === 'description');
        $this->assertTrue($painting->getSlug() === 'slug');
        $this->assertTrue($painting->getFile() === 'file');
        $this->assertTrue($painting->getPrice() == 123.00);
        $this->assertTrue($painting->getWidth() == 123.00);
        $this->assertTrue($painting->getHeight() == 123.00);
        $this->assertTrue($painting->getPortfolio() === true);
        $this->assertTrue($painting->getUser() === $user);
        $this->assertContains($category, $painting->getCategories());
    }
    public function testIsFalse(): void
    {

        $category = new Category();
        $category->setName('name')
            ->setDescription('description')
            ->setSlug('slug');

        $user = new User();
        $user->setEmail('true@test.test')
            ->setFirstName('firstname')
            ->setLastName('lastname')
            ->setAbout('about')
            ->setPassword('password')
            ->setInstagram('instagram');

        $painting = new Painting();
        $painting->setWidth(123, 00)
            ->setHeight(123, 00)
            ->setName('name')
            ->setDescription('description')
            ->setPortfolio('portfolio')
            ->setOnSale(true)
            ->setFile('file')
            ->setPrice(123, 00)
            ->setSlug('slug')
            ->setUser($user)
            ->addCategory($category)
            ->setCompletionDate(new DateTime())
            ->setCreatedAt(new DateTime());

        $this->assertFalse($painting->getName() === 'false');
        $this->assertFalse($painting->getDescription() === 'false');
        $this->assertFalse($painting->getSlug() === 'false');
        $this->assertFalse($painting->getFile() === 'false');
        $this->assertFalse($painting->getPrice() == 100);
        $this->assertFalse($painting->getWidth() == 100);
        $this->assertFalse($painting->getHeight() == 100);
        $this->assertFalse($painting->getPortfolio() === false);
        $this->assertFalse($painting->getUser() === new User());
        $this->assertNotContains(new Category(), $painting->getCategories());
    }
    public function testIsEmpty(): void
    {
        $painting = new Painting();

        $this->assertEmpty($painting->getName());
        $this->assertEmpty($painting->getDescription());
        $this->assertEmpty($painting->getSlug());
        $this->assertEmpty($painting->getFile());
        $this->assertEmpty($painting->getPrice());
        $this->assertEmpty($painting->getWidth());
        $this->assertEmpty($painting->getHeight());
        $this->assertEmpty($painting->getPortfolio());
        $this->assertEmpty($painting->getUser());
        $this->assertEmpty($painting->getCategories());
    }
}
