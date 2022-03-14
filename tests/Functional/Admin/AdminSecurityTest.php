<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class AdminSecurityTest extends WebTestCase
{
    public function testAdminLogin(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_admin_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'john@doe.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_admin_homePage');
    }

    public function testAdminLogout(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_admin_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'john@doe.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_admin_homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_admin_logout'));
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    public function testAdminAlreadyLoginRedirectToHomePage(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_admin_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'john@doe.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_admin_homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_admin_login'));
        $client->followRedirect();
        self::assertRouteSame('security_admin_homePage');
    }

    public function testTryingToGoAdminHomePageWithoutConnectedWithAdminAccount(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_admin_homePage'));
        $client->followRedirect();
        self::assertRouteSame('security_admin_login');

    }
}
