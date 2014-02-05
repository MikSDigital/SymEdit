<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle;

use SymEdit\Bundle\SeoBundle\DependencyInjection\Compiler\GetSeoCalculators;
use SymEdit\Bundle\SeoBundle\DependencyInjection\SymEditSeoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSeoBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GetSeoCalculators());
    }

    public function getContainerExtension()
    {
        return new SymEditSeoExtension();
    }
}
