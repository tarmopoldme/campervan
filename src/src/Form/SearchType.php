<?php

namespace App\Form;

use App\Entity\Station;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Demand dashborad filter form configuration
 */
class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stationId', EntityType::class, [
                    'class' => Station::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Please choose a station',
                    'empty_data' => null,
                ]
            )
            ->add('dateFrom', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'data' => (new DateTime()),
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('dateUntil', DateType::class, [
                'widget' => 'single_text',
                'data' => (new DateTime())->modify('last day of this month'),
                'html5' => false,
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('filterSubmit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'formnovalidate' => 'formnovalidate'],
                'label' => 'Filter'
            ]);
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'filter';
    }
}
