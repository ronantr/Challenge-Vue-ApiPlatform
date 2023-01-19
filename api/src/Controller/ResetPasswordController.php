<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ResetPasswordController extends AbstractController
{

    public function __construct(private RequestStack $requestStack, private ManagerRegistry $managerRegistry)
    {
    }

    public function __invoke()
    {
        $email = json_decode($this->requestStack->getCurrentRequest()->getContent(), true)['email'];
        $user = $this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user) {
            $user->setToken(bin2hex(random_bytes(32)));
            $this->managerRegistry->getManager()->flush();
            return $this->json(['message' => 'Un email de réinitialisation de mot de passe vous a été envoyé']);
        }
        return $this->json(['message' => 'Aucun utilisateur trouvé avec cet email'], 404);
        
    }
}
