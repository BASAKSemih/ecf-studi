<?php

namespace App\Tests\Functional\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class RegistrationTest extends WebTestCase
{
    public function testSuccessRegistrationUser(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_registration'));

        $form = $crawler->filter('form[name=user]')->form([
            'user[email]' => 'user@yahoo.com',
            'user[firstName]' => 'user',
            'user[lastName]' => 'user',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_user_login');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneByEmail('user@yahoo.com');
        $this->assertSame($user->getLastName(), 'user');
    }

    public function testUserAuthenticatedGoingOnRegistrationUrl(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'mercedes@c63.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_registration'));
        $client->followRedirect();
        self::assertRouteSame('user_homePage');
    }
}
