<?php

namespace Mouseketeers\Elements\Slideshow\Model;

use Dynamic\BaseObject\Model\BaseElementObject;
use Mouseketeers\Elements\Slideshow\Elements\ElementSlideshow;
use SilverStripe\Forms\FieldList;

 
class ElementSlideshowSlide extends BaseElementObject
{

    private static $db = array(
        'Sort' => 'Int',
    );


    private static $has_one = array(
        'ElementSlideshow' => ElementSlideshow::class,
    );


    private static $table_name = 'ElementSlideshowSlide';


    private static $summary_fields = [
        'Summary',
    ];


    private static $default_sort = 'Sort';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName(array(
                'ElementSlideshowID',
                'Sort',
            ));

            $fields->dataFieldByName('Image');
        });

        return parent::getCMSFields();
    }

    public function getPage()
    {
        $page = null;

        if ($this->ElementSlideshow()) {
            if ($this->ElementSlideshow()->hasMethod('getPage')) {
                $page = $this->ElementSlideshow()->getPage();
            }
        }

        return $page;
    }

    public function getSummary()
    {
        return $this->dbObject('Content')->Summary(20);
    }
}
