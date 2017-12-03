<?php
/*
* This file is part of Contao.
*
* Copyright (c) 2017 Jan Karai
*
* @license LGPL-3.0+
*/
namespace Mailwurm\BelegungsplanBundle\Tests\EventListener;
use Contao\Config;
use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Mailwurm\BelegungsplanBundle\EventListener\InsertTagsListener;
use Mailwurm\BelegungsplanCategoryModel;
use Mailwurm\BelegungsplanObjekteModel;
use Mailwurm\BelegungsplanCalenderModel;

use Contao\FaqCategoryModel;
use Contao\FaqModel;

use Contao\PageModel;
use PHPUnit\Framework\TestCase;
/**
 * Tests the InsertTagsListener class.
 *
 * @author Jan Karai <http://www.sachsen-it.de>
 */
class InsertTagsListenerTest extends TestCase {
    /**
    * Tests the object instantiation.
    */
    public function testCanBeInstantiated() {
        $listener = new InsertTagsListener($this->mockContaoFramework());
        $this->assertInstanceOf('Mailwurm\BelegungsplanBundle\EventListener\InsertTagsListener', $listener);
    }
    /**
    * Tests that the listener returns a replacement string.
    */
    public function testReplacesTheFaqTags()
    {
        $listener = new InsertTagsListener($this->mockContaoFramework());
        $this->assertSame(
            '<a href="belegungsplan/what-does-foobar-mean.html" title="What does &quot;foobar&quot; mean?">What does "foobar" mean?</a>',
            $listener->onReplaceInsertTags('belegungsplan::2')
        );
        $this->assertSame(
            '<a href="belegungsplan/what-does-foobar-mean.html" title="What does &quot;foobar&quot; mean?">',
            $listener->onReplaceInsertTags('belegungsplan_open::2')
        );
        $this->assertSame(
            'belegungsplan/what-does-foobar-mean.html',
            $listener->onReplaceInsertTags('belegungsplan_url::2')
        );
        $this->assertSame(
            'What does &quot;foobar&quot; mean?',
            $listener->onReplaceInsertTags('belegungsplan_title::2')
        );
    }
    /**
    * Tests that the listener returns false if the tag is unknown.
    */
    public function testReturnsFalseIfTheTagIsUnknown() {
        $listener = new InsertTagsListener($this->mockContaoFramework());
        $this->assertFalse($listener->onReplaceInsertTags('link_url::2'));
    }
    /**
    * Tests that the listener returns an empty string if there is no model.
    */
    public function testReturnsAnEmptyStringIfThereIsNoModel() {
        $listener = new InsertTagsListener($this->mockContaoFramework(true));
        $this->assertSame('', $listener->onReplaceInsertTags('belegungsplan_url::2'));
    }
    /**
    * Tests that the listener returns an empty string if there is no category model.
    */
    public function testReturnsAnEmptyStringIfThereIsNoCategoryModel() {
        $listener = new InsertTagsListener($this->mockContaoFramework(false, true));
        $this->assertSame('', $listener->onReplaceInsertTags('belegungsplan_url::3'));
    }
    /**
    * Returns a ContaoFramework instance.
    *
    * @param bool $noBelegungsplanModel
    * @param bool $noBelegungsplanCategory
    * @param bool $noBelegungsplanCalender
    *
    * @return ContaoFrameworkInterface
    */
    private function mockContaoFramework($noBelegungsplanModel = false, $noBelegungsplanCategory = false, $noBelegungsplanCalender = false) {
        $framework = $this->createMock(ContaoFrameworkInterface::class);
        $framework
            ->method('isInitialized')
            ->willReturn(true)
        ;
        $page = $this->createMock(PageModel::class);
        $page
            ->method('getFrontendUrl')
            ->willReturn('belegungsplan/what-does-foobar-mean.html')
        ;
        $category = $this->createMock(BelegungsplanCategoryModel::class);
        $category
            ->method('getRelated')
            ->willReturn($page)
        ;
        $obj = $this->createMock(BelegungsplanObjekteModel::class);
        $obj
            ->method('getRelated')
            ->willReturn($noBelegungsplanCategory ? null : $category)
        ;
		
		$cal = $this->createMock(BelegungsplanCalenderModel::class);
        $cal
            ->method('getRelated')
            ->willReturn($noBelegungsplanCalender ? null : $obj)
        ;
		
        $cal
            ->method('__get')
            ->willReturnCallback(function ($key) {
                switch ($key) {
                    case 'id':
                        return 2;
                    case 'gast':
                        return 'what-does-foobar-mean';
                    default:
                        return null;
                }
            })
        ;
        $calModelAdapter = $this
            ->getMockBuilder(Adapter::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByGast'])
            ->getMock()
        ;
        $calModelAdapter
            ->method('findByGast')
            ->willReturn($noBelegungsplanCalender ? null : $cal)
        ;
        $framework
            ->method('getAdapter')
            ->willReturnCallback(function ($key) use ($calModelAdapter) {
                switch ($key) {
                    case BelegungsplanCalenderModel::class:
                        return $calModelAdapter;
                    case Config::class:
                        return $this->mockConfigAdapter();
                    default:
                        return null;
                }
            })
        ;
        return $framework;
    }
    /**
    * Mocks a config adapter.
    *
    * @return Adapter|\PHPUnit_Framework_MockObject_MockObject
    */
    private function mockConfigAdapter() {
        $configAdapter = $this
            ->getMockBuilder(Adapter::class)
            ->disableOriginalConstructor()
            ->setMethods(['isComplete', 'preload', 'getInstance', 'get'])
            ->getMock()
        ;
        $configAdapter
            ->method('isComplete')
            ->willReturn(true)
        ;
        $configAdapter
            ->method('preload')
            ->willReturn(null)
        ;
        $configAdapter
            ->method('getInstance')
            ->willReturn(null)
        ;
        $configAdapter
            ->method('get')
            ->willReturnCallback(function ($key) {
                switch ($key) {
                    case 'characterSet':
                        return 'UTF-8';
                    case 'useAutoItem':
                        return true;
                    default:
                        return null;
                }
            })
        ;
        return $configAdapter;
    }
}
