<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', []);
    }

}