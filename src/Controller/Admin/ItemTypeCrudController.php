<?php

namespace App\Controller\Admin;

use App\Entity\ItemType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\NotBlank;

class ItemTypeCrudController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return ItemType::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {


        parent::persistEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub

    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('name')
                ->setFormTypeOptions([
                    'constraints' => [
                        new NotBlank([
                            'message' => "Name can't be empty"
                        ])
                    ]
                ]),

        ];
    }

}
