<?php

declare(strict_types=1);

namespace App\Controller\User\Security;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected EntityManagerInterface $entityManager, protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    #[Route('/espace-utilisateur/inscription', name: 'security_user_registration')]
    public function registration(Request $request): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes déjà connecter, vous ne pouvez pas vous inscrire');

            return $this->redirectToRoute('homePage');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checkExist = $this->userRepository->findOneByEmail($user->getEmail());
            if (!$checkExist) {
                $passwordHash = $this->passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($passwordHash);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlash('success', "inscription réussiste");

                return $this->redirectToRoute('homePage'); // TODO Redirect to login route
            }
        }

        return $this->render('user/register.html.twig', ['form' => $form->createView()]);
    }

}
