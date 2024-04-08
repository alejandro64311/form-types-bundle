<?php

namespace dsarhoya\FormTypesBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Common Extension
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class CommonExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('camelize', [$this, 'camelizeFilter']),
        ];
    }

    /**
     * camelizeFilter function
     *
     * @param string $value
     * @return string
     */
    public function camelizeFilter(string $value) : string
    {
        if (!is_string($value)) {
            return $value;
        }

        $chunks = explode('_', $value);
        $ucfirsted = array_map(function ($s) {
            return ucfirst($s);
        }, $chunks);

        return lcfirst(implode('', $ucfirsted));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_types.common.twig_extension';
    }
}
