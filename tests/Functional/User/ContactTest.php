<?php

namespace App\Tests\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ContactTest extends WebTestCase
{
    public function testUserContact(): void
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

        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_contact'));
        $form = $crawler->filter('form[name=contact]')->form([
            'contact[email]' => 'user@yahoo.com',
            'contact[topic]' => 3,
            'contact[context]' => "Y'a t'il des réductions ?",
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');
    }
}
