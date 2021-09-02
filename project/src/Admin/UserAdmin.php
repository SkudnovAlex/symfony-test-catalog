<?php

namespace App\Admin;

use App\Entity\Role;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('fio', TextType::class, ['label' => 'ФИО'])
            ->add('login', TextType::class, ['label' => 'Логин'])
            ->add('active', CheckboxType::class, [
                'required' => false,
                'label' => 'Активность',
            ])
            ->add('role', EntityType::class, [
                'label' => 'Роль',
                'class' => Role::class,
                'choice_label' => 'name',
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('id', null, ['label' => 'ID'])
            ->add('fio', null, ['label' => 'ФИО'])
            ->add('login', null, ['label' => 'Логин'])
            ->add('active', null, ['label' => 'Активность'])
            ->add('role.name', null, ['label' => 'Роль']);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('id', null, ['label' => 'ID'])
            ->addIdentifier('fio', null, ['label' => 'Логин'])
            ->add('active', null, ['label' => 'Активность'])
            ->add('role.name', null, ['label' => 'Роль'])
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
            ->add('fio', null, ['label' => 'ФИО'])
            ->add('login', null, ['label' => 'Логин'])
            ->add('active', null, ['label' => 'Активность'])
            ->add('role.name', null, ['label' => 'Роль']);
    }

    public function toString($object): string
    {
        return $object instanceof User ? $object->getFio() : 'User';
    }
}