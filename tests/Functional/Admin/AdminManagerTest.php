<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\ManagerCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

final class AdminManagerTest extends WebTestCase
{
    public function testAdminCreateManager(): void
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

        /** @var AdminUrlGenerator $urlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);
        $client->request('GET', (string)$adminUrlGenerator->setController(ManagerCrudController::class)->setAction(Action::NEW)->generateUrl());
        self::assertResponseIsSuccessful();
        self::assertRouteSame('security_admin_homePage');

        $client->submitForm("Create", [
            'Manager[lastName]' => 'Fréderic',
            'Manager[firstName]' => 'Joe',
            'Manager[email]' => 'fred@joe.com',
            'Manager[password]' => 'password',
        ]);
        $client->submit($form);
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }

}