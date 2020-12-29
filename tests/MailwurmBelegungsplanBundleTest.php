<?php
/*
* This file is part of Contao.
*
* Copyright (c) 2017 Jan Karai
*
* @license LGPL-3.0-or-later
*/
namespace Mailwurm\BelegungsplanBundle\Tests;
use Mailwurm\BelegungsplanBundle\MailwurmBelegungsplanBundle;
use PHPUnit\Framework\TestCase;
/**
* Tests the MailwurmBelegungsplanBundle class.
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class MailwurmBelegungsplanBundleTest extends TestCase {
    /**
    * Tests the object instantiation.
    */
    public function testCanBeInstantiated() {
        $bundle = new MailwurmBelegungsplanBundle();
        $this->assertInstanceOf('Mailwurm\BelegungsplanBundle\MailwurmBelegungsplanBundle', $bundle);
    }
}