<?php

namespace App\Admin;

use App\Entity\Role;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class RoleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('name', TextType::class, ['label' => 'Наименование роли']);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('id', null, ['label' => 'ID'])
            ->add('name', null, ['label' => 'Наименование роли']);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('id', null, ['label' => 'ID'])
            ->addIdentifier('name', null, ['label' => 'Наименование роли']);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id', null, ['label' => 'ID'])
            ->add('name', null, ['label' => 'Наименование роли']);
    }

    public function toString($object): string
    {
        return $object instanceof Role ? $object->getName() : 'Role';
    }
}