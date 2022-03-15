<?php

namespace App\Tests\Functional\Manager;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ManagerSecurityTest extends WebTestCase
{
    public function testManagerLogin(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'solene@liz.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
    }

    public function testManagerLogout(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'solene@liz.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_logout'));
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    public function testManagerAlreadyLoginRedirectToHomePage(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'solene@liz.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_login'));
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
    }
}
