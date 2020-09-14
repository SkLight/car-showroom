<?php declare(strict_types=1);

namespace App\Form\Type;

use App\Form\TradeInForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TradeInType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TradeInForm::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clientId')
            ->add('brand')
            ->add('model')
            ->add('class')
            ->add('price')
            ->add('showroomId');
    }
}
