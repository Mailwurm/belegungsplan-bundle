<?php
/*
* This file is part of Contao.
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\Picker;

use Mailwurm\BelegungsplanCategoryModel;
use Mailwurm\BelegungsplanObjekteModel;
use Mailwurm\BelegungsplanCalenderModel;
use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Contao\CoreBundle\Picker\AbstractPickerProvider;
use Contao\CoreBundle\Picker\DcaPickerProviderInterface;
use Contao\CoreBundle\Picker\PickerConfig;

/**
* Provides the belegungsplan picker.
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class BelegungsplanPickerProvider extends AbstractPickerProvider implements DcaPickerProviderInterface, FrameworkAwareInterface {
	
    use FrameworkAwareTrait;
    /**
    * {@inheritdoc}
    */
    public function getName() {
        return 'belegungsplanPicker';
    }
    /**
    * {@inheritdoc}
    */
    public function supportsContext($context) {
        return 'link' === $context && $this->getUser()->hasAccess('belegungsplan', 'modules');
    }
   
    /**
    * {@inheritdoc}
    */
    public function getDcaTable()
    {
        return 'tl_belegungsplan_objekte';
    }
    
}
