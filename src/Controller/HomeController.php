<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'homePage')]
    public function home(HotelRepository $hotelRepository): Response
    {
        $hotels = $hotelRepository->findAll();

        return $this->render('home/home.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    #[Route('/contacter-le-groupe-hotelier', name: 'visitor_contact')]
    public function createContact(Request $request, EntityManagerInterface $entityManager)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', "Le message à bien été envoyer vous recevrez une réponse rapidement");
            return $this->redirectToRoute('homePage');
        }
        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
