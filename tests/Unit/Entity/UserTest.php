<?php
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserName()
    {
        $user = new User(); // Create User object.
        $user->setName("Prince");
        $this->assertEquals("Prince", $user->getName());
    }

    public function testUserCreate()
    {
        $user = new User();
        $user->setName("John");
        $user->setEmail("john@test.com");
        $this->assertEquals("John", $user->getName());
        $this->assertEquals("john@test.com", $user->getEmail());
    }
}