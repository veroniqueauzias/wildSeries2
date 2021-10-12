<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Résumé',
            ])
            ->add('poster', TextType::class, [
                'label' => 'Nom de l\'image',
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
            ])
            ->add('year', IntegerType::class, [
                'label' => 'année de 1ère diffusion',
            ])
            ->add('category', null, 
            ['choice_label' => 'name',
            ])
            ->add('imageFile', VichImageType::class, [
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'delete_label' => 'Supprimer',
                'download_uri' => true, // not mandatory, default is true
                'download_label' => 'télécharger l\'image',
             
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
