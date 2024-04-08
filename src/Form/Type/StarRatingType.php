<?php

namespace dsarhoya\FormTypesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class StarRatingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        if (isset($options['min'])) {
            $view->vars['attr']['data-min'] = $options['min'];
        }
        if (isset($options['max'])) {
            $view->vars['attr']['data-max'] = $options['max'];
        }
        if (isset($options['step'])) {
            $view->vars['attr']['data-step'] = $options['step'];
        }
        if (isset($options['readonly'])) {
            $view->vars['attr']['data-readonly'] = $options['readonly'] ? 1 : 0;
        }
        if (isset($options['disabled'])) {
            $view->vars['attr']['data-disabled'] = $options['disabled'] ? 1 : 0;
        }
        if (isset($options['size'])) {
            $view->vars['attr']['data-size'] = $options['size'];
        }
        if (isset($options['showClear'])) {
            $view->vars['attr']['data-show-clear'] = $options['showClear'] ? 1 : 0;
        }
        if (isset($options['showCaption'])) {
            $view->vars['attr']['data-show-caption'] = $options['showCaption'] ? 1 : 0;
        }
        if (isset($options['theme'])) {
            $view->vars['attr']['data-theme'] = $options['theme'];
        }
        if (isset($options['language'])) {
            $view->vars['attr']['data-language'] = $options['language'];
        }
        if (isset($options['containerClass'])) {
            $view->vars['attr']['data-container-class'] = $options['containerClass'];
        }
        $view->vars['showTooltip'] = false;
        if (isset($options['ratingDetail'])) {
            $view->vars['showTooltip'] = true;
            $view->vars['performance'] = $options['ratingDetail']['performance'];
            $view->vars['efficiency'] = $options['ratingDetail']['efficiency'];
            $view->vars['knowledge'] = $options['ratingDetail']['knowledge'];
            $view->vars['platformUsage'] = $options['ratingDetail']['platformUsage'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "min" => 0,
            "max" => 5,
            "step" => 1.0,
            "disabled" => null,
            "readonly" => null,
            "size" => "sm",
            "showClear" => null,
            "showCaption" => null,
            "ratingDetail" => null,
            "theme" => 'krajee-fa',
            "language" => 'en',
            "containerClass" => null
        ]);

        $resolver
            ->setAllowedTypes('min', ['integer'])
            ->setAllowedTypes('max', ['integer'])
            ->setAllowedTypes('step', ['float'])
            ->setAllowedTypes('disabled', ['null', 'boolean'])
            ->setAllowedTypes('readonly', ['null', 'boolean'])
            ->setAllowedTypes('showClear', ['null', 'boolean'])
            ->setAllowedTypes('showCaption', ['null', 'boolean'])
            ->setAllowedTypes('ratingDetail', ['null', 'array'])
            ->setAllowedTypes('theme', ['string'])
            ->setAllowedTypes('language', ['string'])
            ->setAllowedTypes('containerClass', ['null','string'])
            ->setAllowedTypes('size', ['string'])
                ->setAllowedValues('size', function ($value) {
                    return in_array($value, ['xl', 'lg', 'md', 'sm', 'xs']);
                })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'start_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return NumberType::class;
    }
}
