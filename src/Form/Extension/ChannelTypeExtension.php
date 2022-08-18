<?php

namespace Ikuzo\SyliusSendinbluePlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ChannelTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isSendinblueActive', CheckboxType::class, [
                'required' => true,
                'label' => 'ikuzo_sendinblue.form.is_active'
            ])
            ->add('sendinblueApiKey', TextType::class, [
                'required' => false,
                'label' => 'ikuzo_sendinblue.form.api_key'
            ])
            ->add('sendinblueListId', TextType::class, [
                'required' => false,
                'label' => 'ikuzo_sendinblue.form.list_id'
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ChannelType::class];
    }
}