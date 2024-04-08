<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DatePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['attr']['data-date-week-start'] = $options['weekStart'];
        $view->vars['attr']['data-date-language'] = strtolower($options['language']);
        $view->vars['attr']['readonly'] = $options['readonly'];
        if ($options['autoclose']) {
            $view->vars['attr']['data-date-autoclose'] = 1;
        }
        if ($options['todayHighlight']) {
            $view->vars['attr']['data-date-today-highlight'] = 1;
        }
        if ($options['todayBtn']) {
            $view->vars['attr']['data-date-today-btn'] = 1;
        }
        if (null !== $options['format']) {
            $view->vars['attr']['data-date-format'] = strtolower($options['format']);
        }
        if (null !== $options['startDate']) {
            $view->vars['attr']['data-date-start-date'] = $options['startDate'];
        }
        if (null !== $options['endDate']) {
            $view->vars['attr']['data-date-end-date'] = $options['endDate'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'single_text',
            'html5' => false,
            'startDate' => null,
            'endDate' => null,
            'language' => 'es',
            'autoclose' => true,
            'todayBtn' => false,
            'todayHighlight' => true,
            'weekStart' => 0,
            'format' => null,
            'readonly' => true,
        ]);

        $resolver
            ->setAllowedTypes('startDate', ['null', 'int'])
            ->setAllowedTypes('endDate', ['null', 'int'])
            ->setAllowedTypes('readonly', ['null', 'boolean'])
            ->setAllowedTypes('autoclose', ['null', 'boolean'])
            ->setAllowedTypes('todayBtn', ['null', 'boolean'])
            ->setAllowedTypes('todayHighlight', ['null', 'boolean'])
            ->setAllowedTypes('format', ['null', 'string'])
            ->setAllowedTypes('weekStart', ['int'])->setAllowedValues('weekStart', function ($value) {
                return in_array($value, range(0, 6));
            })
            ->setAllowedTypes('language', ['string'])->setAllowedValues('language', function ($value) {
                return in_array(strtolower($value), ['en', 'es']);
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'date_picker';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return DateType::class;
    }
}
