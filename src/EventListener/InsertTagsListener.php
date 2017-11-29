<?php
/*
* This file is part of Contao.
*
* Copyright (c) Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Mailwurm\BelegungsplanCategoryModel;
use Mailwurm\BelegungsplanObjekteModel;
use Mailwurm\BelegungsplanCalenderModel;
use Mailwurm\Belegungsplaene;
use Contao\PageModel;
use Contao\StringUtil;
/**
* Handles Belegungsplan insert tags.
*
* @author Jan Karai <http://www.sachsen-it.de>
*/
class InsertTagsListener {
    /**
    * @var ContaoFrameworkInterface
    */
    private $framework;
    /**
    * @var array
    */
    private $supportedTags = [
        'belegungsplan',
        'belegungsplan_open',
        'belegungsplan_url',
        'belegungsplan_title',
    ];
    /**
    * Constructor.
    *
    * @param ContaoFrameworkInterface $framework
    */
    public function __construct(ContaoFrameworkInterface $framework) {
        $this->framework = $framework;
    }
    /**
    * Replaces Belegungsplan insert tags.
    *
    * @param string $tag
    *
    * @return string|false
    */
    public function onReplaceInsertTags($tag) {
        $elements = explode('::', $tag);
        $key = strtolower($elements[0]);
        if (!in_array($key, $this->supportedTags, true)) {
            return false;
        }
        $this->framework->initialize();
        /** @var BelegungsplanObjekteModel $adapter */
        $adapter = $this->framework->getAdapter(BelegungsplanObjekteModel::class);
        $belegungsplan = $adapter->findByIdOrName($elements[1]);
        if (null === $belegungsplan || false === ($url = $this->generateUrl($belegungsplan))) {
            return '';
        }
        return $this->generateReplacement($belegungsplan, $key, $url);
    }
    /**
    * Generates the URL for an Belegungsplan.
    *
    * @param BelegungsplanObjekteModel $belegungsplan
    *
    * @return string|false
    */
    private function generateUrl(BelegungsplanObjekteModel $belegungsplan) {
        /** @var PageModel $jumpTo */
        if(!($category = $belegungsplan->getRelated('pid')) instanceof BelegungsplanCategoryModel
            || !(($jumpTo = $category->getRelated('jumpTo')) instanceof PageModel)
        ) {
            return false;
        }
        /** @var Config $config */
        $config = $this->framework->getAdapter(Config::class);
        return $jumpTo->getFrontendUrl(($config->get('useAutoItem') ? '/' : '/items/').($belegungsplan->name ?: $belegungsplan->id));
    }
    /**
    * Generates the replacement string.
    *
    * @param BelegungsplanObjekteModel $belegungsplan
    * @param string   $key
    * @param string   $url
    *
    * @return string|false
    */
    private function generateReplacement(BelegungsplanObjekteModel $belegungsplan, $key, $url) {
        switch ($key) {
            case 'belegungsplan':
                return sprintf(
                    '<a href="%s" title="%s">%s</a>',
                    $url,
                    StringUtil::specialchars($belegungsplan->name),
                    $belegungsplan->question
                );
            case 'belegungsplan_open':
                return sprintf(
                    '<a href="%s" title="%s">',
                    $url,
                    StringUtil::specialchars($belegungsplan->name)
                );
            case 'belegungsplan_url':
                return $url;
            case 'belegungsplan_title':
                return StringUtil::specialchars($belegungsplan->name);
        }
        return false;
    }
}
