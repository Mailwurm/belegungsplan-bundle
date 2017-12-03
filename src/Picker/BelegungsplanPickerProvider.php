<?php
/*
* This file is part of Contao.
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\Picker;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Contao\CoreBundle\Picker\AbstractPickerProvider;
use Contao\CoreBundle\Picker\DcaPickerProviderInterface;
use Contao\CoreBundle\Picker\PickerConfig;
use Mailwurm\BelegungsplanCategoryModel;
use Mailwurm\BelegungsplanObjekteModel;
use Mailwurm\BelegungsplanCalenderModel;

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
    public function supportsValue(PickerConfig $config) {
        return false !== strpos($config->getValue(), '{{belegungsplan_url::');
    }
    /**
    * {@inheritdoc}
    */
    public function getDcaTable()
    {
        return 'tl_belegungsplan_objekte';
    }
    /**
    * {@inheritdoc}
    */
    public function getDcaAttributes(PickerConfig $config) {
        $attributes = ['fieldType' => 'radio'];
        if ($this->supportsValue($config)) {
            $attributes['value'] = str_replace(['{{belegungsplan_url::', '}}'], '', $config->getValue());
        }
        return $attributes;
    }
    /**
    * {@inheritdoc}
    */
    public function convertDcaValue(PickerConfig $config, $value) {
        return '{{belegungsplan_url::'.$value.'}}';
    }
    /**
    * {@inheritdoc}
    */
    protected function getRouteParameters(PickerConfig $config = null) {
        $params = ['do' => 'belegungsplan'];
        if (null === $config || !$config->getValue() || false === strpos($config->getValue(), '{{belegungsplan_url::')) {
            return $params;
        }
        $value = str_replace(['{{belegungsplan_url::', '}}'], '', $config->getValue());
        if (null !== ($belegungsplanId = $this->getBelegungsplanCategoryId($value))) {
            $params['table'] = 'tl_belegungsplan_objekte';
            $params['id'] = $belegungsplanId;
        }
        return $params;
    }
    /**
    * Returns the Belegungsplan category ID.
    *
    * @param int $id
    *
    * @return int|null
    */
    private function getBelegungsplanCategoryId($id)
    {
        /** @var BelegungsplanObjekteModel $belegungplanAdapter */
        $belegungplanAdapter = $this->framework->getAdapter(BelegungsplanObjekteModel::class);
        if (!($belegungplanModel = $belegungplanAdapter->findById($id)) instanceof BelegungsplanObjekteModel) {
            return null;
        }
        if (!($belegungplanCategory = $belegungplanModel->getRelated('pid')) instanceof BelegungsplanCategoryModel) {
            return null;
        }
        return $belegungplanCategory->id;
    }
}
