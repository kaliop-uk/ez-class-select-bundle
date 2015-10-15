<?php

namespace Kaliop\ClassSelectBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Kaliop\ClassSelectBundle\DependencyInjection\KaliopClassSelectExtension;


class KaliopClassSelectBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new KaliopClassSelectExtension();
    }
}
