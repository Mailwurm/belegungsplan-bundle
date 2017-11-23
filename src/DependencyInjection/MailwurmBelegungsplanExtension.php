<?php
/*
* This file is part of Contao.
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
* Adds the bundle services to the container.
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class MailwurmBelegungsplanExtension extends Extension {
    /**
    * {@inheritdoc}
    */
    public function load(array $mergedConfig, ContainerBuilder $container) {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('listener.yml');
        $loader->load('services.yml');
    }
}