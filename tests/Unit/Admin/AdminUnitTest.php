<?php

declare(strict_types=1);

namespace App\Tests\Unit\Admin;

use App\Entity\Admin;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class AdminUnitTest extends TestCase
{
    public function testAdminAssertSame(): void
    {
        $admin = new Admin();
        $dateTime = new DateTimeImmutable();
        $admin
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('john@doe.com')
            ->setPassword('password')
            ->setRoles(array('ADMIN'))
            ->setCreatedAt($dateTime);

        $this->assertSame($admin->getFirstName(),  'John');
        $this->assertSame($admin->getLastName(),  'Doe');
        $this->assertSame($admin->getEmail(),  'john@doe.com');
        $this->assertSame($admin->getPassword(),  'password');
        $this->assertSame($admin->getCreatedAt(),  $dateTime);
        $this->assertSame($admin->getUsername(),  'john@doe.com');
        $this->assertSame($admin->getUserIdentifier(),  'john@doe.com');
        $this->assertSame($admin->getRoles(), ["ADMIN"]);
        $this->assertNull($admin->getSalt());
        $this->assertNull($admin->getId());


    }

}