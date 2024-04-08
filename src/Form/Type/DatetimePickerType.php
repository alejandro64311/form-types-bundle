<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DatetimePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['attr']['readonly'] = $options['readonly'];
        $view->vars['attr']['data-date-locale'] = $options['language'];
        $view->vars['attr']['data-date-step'] = $options['step'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'single_text',
            'html5' => false,
            'language' => 'es',
            'format' => 'dd/MM/yyyy HH:mm',
            'step' => 15,
            'readonly' => true,
        ]);
        // $resolver->setAllowedTypes('format', ['string']);
        $resolver->setAllowedTypes('step', ['int']);
        $resolver->setAllowedTypes('readonly', ['boolean']);
        $resolver->setAllowedTypes('language', ['string'])->setAllowedValues('language', function ($value) {
            return in_array(strtolower($value), ['en', 'es']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'datetime_picker';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return DateTimeType::class;
    }
}
