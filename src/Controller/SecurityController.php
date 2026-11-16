<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('auth/login.html.twig', [
            'error' => $utils->getLastAuthenticationError(),
            'last_username' => $utils->getLastUsername(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): never
    {
        throw new \LogicException('Hanteras av brandväggen.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em,
        Security $security,
    ): Response {
        $errors = [];

        if ($request->isMethod('POST')) {
            $r = $request->request;
            $email = mb_strtolower(trim((string) $r->get('email')));
            $password = (string) $r->get('plainPassword');
            $first = trim((string) $r->get('firstName'));
            $last = trim((string) $r->get('lastName'));

            if (!$this->isCsrfTokenValid('register', (string) $r->get('_csrf_token'))) {
                $errors[] = 'Your session expired. Please try again.';
            }
            if ($first === '' || $last === '') {
                $errors[] = 'Please enter your first and last name.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            } elseif ($em->getRepository(User::class)->findOneBy(['email' => $email])) {
                $errors[] = 'An account with this email already exists.';
            }
            if (strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
                $errors[] = 'Password needs 8+ characters, a number and a special symbol.';
            }
            if (!$r->get('agreeTerms')) {
                $errors[] = 'You must accept the Terms of Service.';
            }

            if (!$errors) {
                $user = (new User())
                    ->setEmail($email)
                    ->setFirstName($first)
                    ->setLastName($last)
                    ->setPhone(trim((string) $r->get('phone')) ?: null)
                    ->setRoles(['ROLE_USER']);
                $user->setPassword($hasher->hashPassword($user, $password));

                $em->persist($user);
                $em->flush();

                // Logga in direkt efter registrering
                return $security->login($user, 'form_login', 'main')
                    ?? $this->redirectToRoute('home');
            }
        }

        return $this->render('auth/register.html.twig', ['errors' => $errors]);
    }
}