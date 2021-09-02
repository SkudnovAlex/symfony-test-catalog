<?php

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('name', TextType::class, ['label' => 'Наименование категории'])
            ->add('code', TextType::class, ['label' => 'Код категории'])
            ->add('parent', IntegerType::class, [
                'required' => false,
                'label' => 'Родитель'
            ])
            ->add('sort', IntegerType::class, [
                'required' => false,
                'label' => 'Сортировка'
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('id', null, ['label' => 'ID'])
            ->add('name', null, ['label' => 'Наименование товара'])
            ->add('code', null, ['label' => 'Код категории'])
            ->add('parent', null, ['label' => 'Родитель'])
            ->add('sort', null, ['label' => 'Сортировка']);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('id', null, ['label' => 'ID'])
            ->addIdentifier('name', null, ['label' => 'Наименование категории'])
            ->add('code', null, ['label' => 'Код категории'])
            ->add('parent', null, ['label' => 'Родитель'])
            ->add('sort', null, ['label' => 'Сортировка'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
                'label' => 'Действия'
            ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id', null, ['label' => 'ID'])
            ->add('name', null, ['label' => 'Наименование категории'])
            ->add('code', null, ['label' => 'Код категории'])
            ->add('parent', null, ['label' => 'Родитель'])
            ->add('sort', null, ['label' => 'Сортировка']);
    }

    public function toString($object): string
    {
        return $object instanceof Category ? $object->getName() : 'Category';
    }
}