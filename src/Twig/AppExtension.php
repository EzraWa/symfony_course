<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 08/03/2019
 * Time: 10:43
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function priceFilter($number)
    {
        return '$' . number_format($number, 2, '.', ',');
    }

}