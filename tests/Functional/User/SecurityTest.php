<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class SecurityTest extends WebTestCase
{
    public function testUserAuthentication(): void
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
    }

    public function testUserAuthenticatedGoingOnLoginUrl(): void
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
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $client->followRedirect();
        self::assertRouteSame('user_homePage');
    }
}
