<?php

namespace PodwysockiCMS\AdminBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NewPageForm extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('pageTitle', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Wpisz tytuł strony ...'
                )
            ))
            ->add('pageContent', TextareaType::class,array(
                'required' => false
            ))
            ->add('link', TextType::class,array(
                'required' => false
            ))
            ->add('visibility', ChoiceType::class,array(
                'choices' => array(
                  'Tak' => 'visible',
                  'Nie' => 'hidden'
                ),
                'expanded' => true,
                'required' => true,
                'multiple' => false
            ))
            ->add('parent', TextType::class,array(
                'required' => false
            ))
            ->add('published', DateTimeType::class,array(
                'mapped' => false
            ))
            ->add('categories', ChoiceType::class, array(
                   'required' => false,
                   'mapped' => false,
                   'expanded' => true,
                   'multiple' => true,
                   'choices' => $this->getCategories($options)
                ))
            ->add('zapisz', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PodwysockiCMS\AdminBundle\Entity\Pages',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        ));
    }
    
    public function getCategories($options)
    {
        $page = $options['data'];
        
        $choices = array();
        foreach($page->categories as $category) {
           $choices = $choices + array($category->getCategoryName()=>$category->getID());
        }
     
        return $choices;
    }
    
}

