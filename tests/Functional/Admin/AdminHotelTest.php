<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\HotelCrudController;
use App\Controller\Admin\ManagerCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

final class AdminHotelTest extends WebTestCase
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
        $client->request('GET', (string)$adminUrlGenerator->setController(HotelCrudController::class)->setAction(Action::NEW)->generateUrl());
        self::assertResponseIsSuccessful();
        self::assertRouteSame('security_admin_homePage');

        $client->submitForm("Create", [
            'Hotel[name]' => 'Best Hotel',
            'Hotel[description]' => 'A hotel with spa',
            'Hotel[address]' => 'see in google map',
            'Hotel[city]' => 'cityhotel',
            'Hotel[manager]' => 1
        ]);
        $client->submit($form);
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }

}