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
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $year = date('Y');
           
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Résumé',
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
            ])
            ->add('year', IntegerType::class, [
                'label' => 'année de 1ère diffusion',
                'constraints' => [
                    new LessThanOrEqual ([
                        'value' => $year,
                        'message' => 'Je ne suis pas dans le futur!'
                    ]),
                    new GreaterThanOrEqual ([
                        'value' => '1951',
                        'message' => 'Le saviez-vous? La toute 1ère série était une série américaine appelée "I love Lucy".
                        Elle a été diffusée au Etats-Unis à partir du 15 octobre 1951. (source:Wikipédia) Vous ne pouvez donc pas entrer une année inférieure.'
                    ])
                ]
            ])
            ->add('category', null, 
            ['choice_label' => 'name',
            ])
            ->add('imageFile', VichImageType::class, [
                'label' =>'affiche de la série',
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
