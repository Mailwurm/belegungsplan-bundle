<?php
/*
* This file is part of Contao.
*
* Copyright (c) 2017 Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\Tests\DependencyInjection;
use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Mailwurm\BelegungsplanBundle\DependencyInjection\MailwurmBelegungsplanExtension;
use Mailwurm\BelegungsplanBundle\EventListener\InsertTagsListener;
use Mailwurm\BelegungsplanBundle\Picker\BelegungsplanPickerProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
/**
* Tests the ContaoFaqExtension class.
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class MailwurmBelegungsplanExtensionTest extends TestCase {
    /**
    * @var ContainerBuilder
    */
    private $container;
    /**
    * {@inheritdoc}
    */
    protected function setUp() {
        parent::setUp();
        $this->container = new ContainerBuilder(new ParameterBag(['kernel.debug' => false]));
        $extension = new MailwurmBelegungsplanExtension();
        $extension->load([], $this->container);
    }
    /**
    * Tests the object instantiation.
    */
    public function testCanBeInstantiated() {
        $extension = new MailwurmBelegungsplanExtension();
        $this->assertInstanceOf('Mailwurm\BelegungsplanBundle\DependencyInjection\MailwurmBelegungsplanExtension', $extension);
    }
    /**
     * Tests the mailwurm_belegungsplan.listener.insert_tags service.
     */
    public function testRegistersTheInsertTagsListener() {
        $this->assertTrue($this->container->has('mailwurm_belegungsplan.listener.insert_tags'));
        $definition = $this->container->getDefinition('mailwurm_belegungsplan.listener.insert_tags');
        $this->assertSame(InsertTagsListener::class, $definition->getClass());
        $this->assertSame('contao.framework', (string) $definition->getArgument(0));
    }
    /**
    * Tests the mailwurm_belegungsplan.picker.belegungsplan_provider service.
    */
    public function testRegistersTheEventPickerProvider() {
        $this->assertTrue($this->container->has('mailwurm_belegungsplan.picker.belegungsplan_provider'));
        $definition = $this->container->getDefinition('mailwurm_belegungsplan.picker.belegungsplan_provider');
        $this->assertSame(BelegungsplanPickerProvider::class, $definition->getClass());
        $this->assertFalse($definition->isPublic());
        $this->assertSame('knp_menu.factory', (string) $definition->getArgument(0));
        $conditionals = $definition->getInstanceofConditionals();
        $this->assertArrayHasKey(FrameworkAwareInterface::class, $conditionals);
        /** @var ChildDefinition $childDefinition */
        $childDefinition = $conditionals[FrameworkAwareInterface::class];
        $this->assertSame('setFramework', $childDefinition->getMethodCalls()[0][0]);
        $tags = $definition->getTags();
        $this->assertSame('setTokenStorage', $definition->getMethodCalls()[0][0]);
        $this->assertArrayHasKey('contao.picker_provider', $tags);
        $this->assertSame(64, $tags['contao.picker_provider'][0]['priority']);
    }
}
