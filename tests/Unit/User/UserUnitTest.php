<?php

namespace App\Tests\Unit\User;

use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testuserAssertSame(): void
    {
        $user = new User();
        $dateTime = new DateTimeImmutable();
        $user
            ->setFirstName('User')
            ->setLastName('User')
            ->setEmail('user@email.com')
            ->setPassword('password')
            ->setIsVerified(false)
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt($dateTime);

        $this->assertSame($user->getFirstName(), 'User');
        $this->assertSame($user->getLastName(), 'User');
        $this->assertSame($user->getEmail(), 'user@email.com');
        $this->assertSame($user->getPassword(), 'password');
        $this->assertSame($user->getCreatedAt(), $dateTime);
        $this->assertSame($user->getUsername(), 'user@email.com');
        $this->assertSame($user->getUserIdentifier(), 'user@email.com');
        $this->assertSame($user->getIsVerified(), false);
        $this->assertSame($user->getRoles(), ['ROLE_USER']);
        $this->assertNull($user->getSalt());
        $this->assertNull($user->getId());
    }
}
