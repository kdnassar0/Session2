<?php

namespace App\Form;

use App\Entity\Cours;

use App\Entity\Session;
use App\Entity\Programe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProgrameTypePhpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree',NumberType::class,['attr'=>['class'=>'formChamp']])
            ->add('session',EntityType::class,[
                'class'=>Session::class,
                'choice_label'=>'nomSession',
                'attr'=> ['class'=>'formChamp']
            ])
            ->add('cours',EntityType::class,[
                'class'=>Cours::class,
                'choice_label'=>'nomCours',
                'attr'=>['class'=>'formChamp']
            ])
            ->add('submit',SubmitType::class,['attr'=>['class'=>'formChamp']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programe::class,
        ]);
    }
}
