<?php

namespace App\Controller\Admin;

use App\Entity\Manager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ManagerCrudController extends AbstractCrudController
{
    public function __construct(protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Manager::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName'),
            TextField::new('lastName'),
            EmailField::new('email'),
            TextField::new('password')->setFormType(PasswordType::class),
        ];
    }

    /** @phpstan-ignore-next-line  */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /* @var Manager $entityInstance */
        $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
