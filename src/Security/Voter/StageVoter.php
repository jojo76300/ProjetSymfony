<?php

namespace App\Security\Voter;

use App\Entity\Stage;
use App\Entity\Utilisateur;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class StageVoter extends Voter
{
    public const EDIT = 'STAGE_EDIT';
    public const DELETE = 'STAGE_DELETE';

    public function __construct(
        private Security $security,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // On vérifie si l'attribut est l'un de ceux qu'on gère
        // Et si le sujet est bien une instance de Stage
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Stage;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur n'est pas connecté ou n'est pas un Utilisateur valide
        if (!$user instanceof Utilisateur) {
            return false;
        }

        // ROLE_ADMIN a tous les droits
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        /** @var Stage $stage */
        $stage = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($stage, $user),
            self::DELETE => $this->canDelete($stage, $user),
            default => false,
        };
    }

    private function canEdit(Stage $stage, Utilisateur $user): bool
    {
        // L'enseignant peut modifier s'il est le prof de suivi OU le prof de visite
        return $stage->getProfSuivi() === $user || $stage->getProfVisite() === $user;
    }

    private function canDelete(Stage $stage, Utilisateur $user): bool
    {
        // Seuls les Admins peuvent supprimer un stage (géré dans voteOnAttribute)
        // Donc un simple prof ne peut jamais supprimer
        return false;
    }
}