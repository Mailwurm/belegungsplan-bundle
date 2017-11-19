<?php
/*
 * This file is part of Contao.
 *
 * Copyright (c) Jan Karai
 *
 * @license LGPL-3.0+
 */
namespace Mailwurm\BelegungsplanBundle\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
/**
 * Adds the bundle services to the container.
 *
 * @author Jan Karai
 */
class MailwurmBelegungsplanExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/contao/config'));
        $loader->load('services.php');
    }
}
