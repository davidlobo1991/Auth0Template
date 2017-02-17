<?php
namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use UserBundle\Entity\User;

class UserAdmin extends AbstractAdmin {
    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
            ->with('General',[
                'class' => 'col-md-6',
                'box_class' => 'box box-solid box-danger'
            ])
            ->add('email', 'email')
            ->end();

        $formMapper
            ->with('Information',[
                'class' => 'col-md-6'
            ])
            ->add('firstName', 'text', ['required' => false])
            ->add('lastName', 'text', ['required' => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('email');
        $datagridMapper->add('firstName');
        $datagridMapper->add('lastName');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('email');
        $listMapper->add('firstName');
        $listMapper->add('lastName');
        $listMapper->add('creationDate');
        $listMapper->add('modificationDate');
    }

    public function toString($object) {

        if($object instanceof User) {
            if(!empty($object->getFirstName()) && !empty($object->getLastName()))
                return $object->getFirstName() . ' ' .$object->getLastName();

            return $object->getEmail();
        }

        return 'User';
    }
}
