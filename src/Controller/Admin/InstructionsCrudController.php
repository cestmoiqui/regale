<?php

namespace App\Controller\Admin;

use App\Entity\Instructions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InstructionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Instructions::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield TextField::new('title', 'Titre');

        yield TextEditorField::new('content', 'Contenu');
    }
}
