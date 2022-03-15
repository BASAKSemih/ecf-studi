<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\AdminCrudController;
use App\Controller\Admin\AdminDashBoardController;
use App\Controller\Admin\ManagerCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

final class AdminTest extends WebTestCase
{
    public function testAdminCreateAdmin(): void
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
        $client->request('GET', (string) $adminUrlGenerator->setController(AdminCrudController::class)->setAction(Action::NEW)->setDashboard(AdminDashBoardController::class)->generateUrl());
        self::assertResponseIsSuccessful();
        self::assertRouteSame('security_admin_homePage');

        $client->submitForm('Create', [
            'Admin[lastName]' => 'admin',
            'Admin[firstName]' => 'admin',
            'Admin[email]' => 'admin@admin.com',
            'Admin[password]' => 'password',
        ]);
        $client->submit($form);
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testAdminEditAdmin(): void
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
        $client->request('GET', (string)
        $adminUrlGenerator->setController(AdminCrudController::class)
            ->setAction(Action::EDIT)
            ->setDashboard(AdminDashBoardController::class)
            ->setEntityId(2)
            ->generateUrl());
        self::assertResponseIsSuccessful();
        self::assertRouteSame('security_admin_homePage');

        $client->submitForm('Save changes', [
            'Admin[lastName]' => 'edited admin',
            'Admin[firstName]' => 'edited admin',
            'Admin[email]' => 'edited@admin.com',
            'Admin[password]' => 'password',
        ]);
        $client->submit($form);
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

}