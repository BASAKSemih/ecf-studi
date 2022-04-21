<?php

namespace App\Tests\Unit\User;

use App\Entity\Contact;
use Monolog\Test\TestCase;

class ContactUnitTest extends TestCase
{
    public function testContactIsSame()
    {
        $contact = new Contact();
        $dateTime = new \DateTimeImmutable();
        $contact
            ->setCreatedAt($dateTime)
            ->setContext('context')
            ->setTopic('topic')
            ->setUser(null)
            ->setEmail('email@email.com');

        $this->assertSame($contact->getCreatedAt(), $dateTime);
        $this->assertNull($contact->getId());
        $this->assertNull($contact->getUser());
    }
}
