<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class OrderCrudController extends AbstractCrudController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
                ->add('index', 'detail');
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        
        return [
            DateTimeField::new('createdAt', 'Vendu le'),
            TextField::new('user', 'utilisateur'),
            MoneyField::new('total', 'total produit')->setCurrency('EUR'),
            TextField::new('carrierName', 'transporteur'),
            MoneyField::new('carrierPrice', 'frait de port')->setCurrency('EUR'),
            BooleanField::new('isPaid', 'payée'),
            ArrayField::new('orderDetails', 'Produit acheté')
        ];
    }
    
}
