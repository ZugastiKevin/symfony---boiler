<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RgpdController extends AbstractController
{
    #[Route('/politique-de-confidentialite', name: 'confidentialite')]
    public function confidentialite(): Response
    {
        return $this->render('rgpd/confidentialite.html.twig');
    }

    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentions(): Response
    {
        return $this->render('rgpd/mentions_legales.html.twig');
    }

    #[Route('/conditions-generales', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('rgpd/cgu.html.twig');
    }
}
