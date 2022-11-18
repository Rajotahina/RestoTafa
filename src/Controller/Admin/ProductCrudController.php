<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductCrudController extends AbstractCrudController
{

    public const ACTION_DUPLICATE = 'duplicate';
    public const PRODUCT_BASE_PATH ='upload/images/products';
    public const PRODUCT_UPLOAD_DIR ='public/upload/images/products';
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
        ->linkToCrudAction('duplicateProduct')
        ->setCssClass('btn btn-info');
        return $actions
        ->add(Crud::PAGE_EDIT , $duplicate)
        ->reorder(Crud::PAGE_EDIT ,[self::ACTION_DUPLICATE ,Action::SAVE_AND_RETURN]);
    }
    
    // public static function getEntityFqcn(): string
    // {
    //     return Product::class;
    // }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('MGA'),
            ImageField::new('image')
                ->setBasePath(self::PRODUCT_BASE_PATH)
                ->setUploadDir(self::PRODUCT_UPLOAD_DIR)
                ->setSortable(false),
            BooleanField::new('active'),
            AssociationField::new('Categorie'),
            //DateTimeField::new('updatedAt')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }
    public function persistEntity(EntityManagerInterface $em , $entityInstance): void
    {
        if(!$entityInstance instanceof Product) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable );
        parent::persistEntity($em ,$entityInstance);
    }
    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Product) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable() );
        parent::updateEntity($em ,$entityInstance);  
    }

    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Product) return;
        foreach($entityInstance->getProducts as $product){
            $em->remove($product);
        }
        parent::deleteEntity($em , $entityInstance);
    }

    public function duplicateProduct(AdminContext $context ,
    AdminUrlGenerator $adminUrlGenerator ,
    EntityManagerInterface $em ): HttpFoundationResponse
    {
        $product = $context->getEntity()->getInstance();
        $duplicateProduct = clone $product;
        parent::persistEntity($em ,$duplicateProduct);

        $url = $adminUrlGenerator->setController(self::class)
        ->setAction(Action::DETAIL)
        ->setEntityId($duplicateProduct->getId())
        ->generateUrl();

        return $this->redirect($url);
    }
}
    

