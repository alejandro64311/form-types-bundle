<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * SwitchType.
 *
 * @author mati <matias.castro@dsarhoya.cl>
 */
class SwitchType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'first_label' => 'On',
                'second_label' => 'Off',
                'color' => 'teal',
            ])
            ->setAllowedTypes('color', ['string'])
            ->setAllowedValues('color', ['red', 'pink', 'purple', 'deep', 'indigo', 'blue', 'light', 'cyan', 'teal', 'green', 'light', 'lime', 'yellow', 'amber', 'orange', 'deep', 'brown', 'grey', 'blue', 'black', 'white'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['color'] = $options['color'];
        $view->vars['first_label'] = $options['first_label'];
        $view->vars['second_label'] = $options['second_label'];
    }

    public function getParent()
    {
        return CheckboxType::class;
    }
}
