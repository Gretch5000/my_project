<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class RideController extends AbstractController
{
    use TargetPathTrait;

    #[Route('/find-ride', name: 'app_find_ride')]
    public function find(Request $request): Response
    {
        $type = $request->query->get('type') === 'parcel' ? 'parcel' : 'ride';

        if (!$this->getUser()) {
            // Kom ihåg sidan, så man hamnar här efter inloggning/registrering
            $this->saveTargetPath($request->getSession(), 'main', $request->getUri());

            return $this->render('auth/required.html.twig');
        }

        return $this->render('search/results.html.twig', ['type' => $type]);
    }
}