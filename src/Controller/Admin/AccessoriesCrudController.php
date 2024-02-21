<?php

namespace App\Controller\Admin;

use App\Entity\Accessories;
use App\Form\MultipleFileFormType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class AccessoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accessories::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setFormTypeOptions([
                    'required' => true
                ]),

            TextEditorField::new('description')
                ->setFormTypeOptions([
                    'required' => true
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

            ImageField::new('url')
                ->setFormTypeOptions([
                    'label' => 'Cover Image'
                ])
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
                ->setUploadDir("public/assets/images/accessories")
                ->setBasePath("assets/images/accessories"),

            AssociationField::new('accCategory')
                ->setFormTypeOptions([
                    "constraints" => [
                        new NotBlank([
                            'message' => " Can't be empty"
                        ])
                    ]
                ]),

        ];
    }

}
