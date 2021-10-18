<?php

namespace App\Form;

use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = date('Y');
        
        $builder
            ->add('number', integerType::class, [
                'label' => 'numéro de la saison',
            ])
            ->add('year', integerType::class, [
                'label' => '1ère année de diffusion',
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
            ->add('description', textareaType::class, [
                'label' => 'Résumé'
            ])
            ->add('program', null, [
                'choice_label' => 'title', 
                'label'=> 'Série'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
