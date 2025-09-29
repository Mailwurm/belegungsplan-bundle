<?php

declare(strict_types=1);

/*
 * Contao Open Source CMS.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0-or-later
 */

namespace Mailwurm\BelegungsplanBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MailwurmBelegungsplanExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // $configuration = new Configuration(); $config =
        // $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config'),
        );

        $loader->load('services.yaml');
    }
}
