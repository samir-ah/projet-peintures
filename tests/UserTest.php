<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue(): void
    {
      
        $user = new User();
        $user->setEmail('true@test.test')
        ->setFirstName('firstname')
        ->setLastName('lastname')
        ->setAbout('about')
        ->setPassword('password')
        ->setInstagram('instagram');

        $this->assertTrue($user->getEmail() === 'true@test.test');
        $this->assertTrue($user->getFirstName() === 'firstname');
        $this->assertTrue($user->getLastName() === 'lastname');
        $this->assertTrue($user->getAbout() === 'about');
        $this->assertTrue($user->getInstagram() === 'instagram');
    
    }
    public function testIsFalse(): void
    {
      
        $user = new User();
        $user->setEmail('true@test.test')
        ->setFirstName('firstname')
        ->setLastName('lastname')
        ->setAbout('about')
        ->setInstagram('instagram');

        $this->assertFalse($user->getEmail() === 'false@test.test');
        $this->assertFalse($user->getFirstName() === 'false');
        $this->assertFalse($user->getLastName() === 'false');
        $this->assertFalse($user->getAbout() === 'false');
        $this->assertFalse($user->getInstagram() === 'false');
    
    }
    public function testIsEmpty(): void
    {
      
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getFirstName());
        $this->assertEmpty($user->getLastName());
        $this->assertEmpty($user->getAbout());
        $this->assertEmpty($user->getInstagram());
    
    }
}
