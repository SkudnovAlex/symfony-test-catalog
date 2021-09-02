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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('name', TextType::class, ['label' => 'Наименование товара'])
            ->add('code', TextType::class, ['label' => 'Код товара'])
            ->add('price', MoneyType::class, [
                'label' => 'Цена',
                'currency' => 'Rub',
                'required' => false,
            ])
            ->add('active', CheckboxType::class, [
                'required' => false,
                'label' => 'Активность'
            ])
            ->add('sort', IntegerType::class, [
                'required' => false,
                'label' => 'Сортировка'
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категория',
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание товара',
                'required' => false,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('id', null, ['label' => 'ID'])
            ->add('name', null, ['label' => 'Наименование товара'])
            ->add('code', null, ['label' => 'Код товара'])
            ->add('price', null, ['label' => 'Цена'])
            ->add('active', null, ['label' => 'Активность'])
            ->add('sort', null, ['label' => 'Сортировка']);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('id', null, ['label' => 'ID'])
            ->addIdentifier('name', null, ['label' => 'Наименование товара'])
            ->add('price', null, ['label' => 'Цена'])
            ->add('code', null, ['label' => 'Код товара'])
            ->add('active', null, ['label' => 'Активность'])
            ->add('sort', null, ['label' => 'Сортировка'])
            ->add('category.name', null, ['label' => 'Категория'])
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
            ->add('name', null, ['label' => 'Наименование товара'])
            ->add('price', null, ['label' => 'Цена'])
            ->add('code', null, ['label' => 'Код товара'])
            ->add('active', null, ['label' => 'Активность'])
            ->add('sort', null, ['label' => 'Сортировка'])
            ->add('category.name', null, ['label' => 'Категория'])
            ->add('description', null, ['label' => 'Описание товара']);
    }

    public function toString($object): string
    {
        return $object instanceof Product ? $object->getName() : 'Product';
    }
}