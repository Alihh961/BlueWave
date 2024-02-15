<?php

namespace App\Controller\Admin;

use App\Entity\Attributes;
use App\Entity\Category;
use App\Entity\VisionItem;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class VisionItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VisionItem::class;
    }


    public function configureFields(string $pageName): iterable
    {

        $emptyHelpMessage = '';
        if ($pageName == 'edit') {
            $emptyHelpMessage = 'Keep it empty while updating if there is no need to update the Min-Max';
        }
        return [
            AssociationField::new('category')
                ->setFormTypeOptions([
                    "constraints" => [
                        new NotBlank([
                            'message' => "Can't be empty"
                        ])
                    ]
                ]),
            TextField::new('name')
                ->setFormTypeOptions([
                    "constraints" => [
                        new NotBlank([
                            'message' => "Can't be empty"
                        ])
                    ]
                ]),
            MoneyField::new('price')
                ->setCustomOption('storedAsCents', false)
                ->setCurrency('USD')
                ->setNumDecimals(10)
                ->setFormTypeOptions([
                    "constraints" => [

                        new GreaterThan(
                            0,
                            null,
                            "Only positive values"
                        ),
                        new NotBlank([
                            'message' => "Can't be empty"
                        ])
                    ]
                ]),
            BooleanField::new('available'),
            IntegerField::new('visionId')
                ->setFormTypeOptions([
                    "invalid_message" => "Only integers",
                    "constraints" => [

                        new GreaterThan(
                            0,
                            null,
                            "Taille doit être positive."
                        )
                        ,
                        new NotBlank([
                            'message' => " Can't be empty"
                        ])
                    ]
                ]),
                ImageField::new('url', 'image')
                    ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
                    ->setUploadDir("public/assets/images/vision-items")
                    ->setBasePath("assets/images/vision-items"),
            AssociationField::new('itemType')
                ->setFormTypeOptions([
                    "constraints" => [
                        new NotBlank([
                            'message' => " Can't be empty"
                        ])
                    ]
                ]),
            AssociationField::new('params'),
            TextField::new('attribute', 'Min-Max , example => m:10,20 or n if there is no Min-Max')
//                ->hideWhenUpdating()
                ->setHelp($emptyHelpMessage)
                ->setFormTypeOptions([
                    'mapped' => false,


                ]),


        ];

    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $request = $this->getContext()->getRequest();
        $visionItemParameters = $request->request->all();

        // attribute received must be in format m:10,20
        $attribute = $visionItemParameters['VisionItem']['attribute'];

        $attributeArray = explode(':', $attribute);
        $attributeEntity = new Attributes();

        switch ($attributeArray[0]) {
            case 'm' :

                $minMaxArray = explode(',', $attributeArray[1]);

                $attributeEntity->setMinAndMax($minMaxArray);
                $entityInstance->setAttributes($attributeEntity);

                break;

            default :
                $entityInstance->setAttributes(null);
                break;
        }


        parent::persistEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {


        parent::updateEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }
}
