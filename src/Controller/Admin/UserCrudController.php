<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $password = $entityInstance->getPassword();

        $hashedPassword = $this->userPasswordHasher->hashPassword($entityInstance, $password);

        $entityInstance->setPassword($hashedPassword);

        parent::updateEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $password = $entityInstance->getPassword();

        $hashedPassword = $this->userPasswordHasher->hashPassword($entityInstance, $password);

        $entityInstance->setPassword($hashedPassword);

        parent::persistEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
