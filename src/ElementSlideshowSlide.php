<?php

namespace Mouseketeers\Elements\Slideshow;

use SilverStripe\ORM\DataObject;
use Mouseketeers\Elements\Slideshow\ElementSlideshow;
use SilverStripe\Assets\Image;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;

class ElementSlideshowSlide extends DataObject
{

    private static $table_name = 'ElementSlideshowSlide';

    private static $singular_name = 'Slide';
    private static $plural_name = 'Slides';    

    private static $db = [
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Sort' => 'Int'
    ];  

    private static $has_one = [
        'Image' => Image::class,
        'ElementLink' => Link::class,
        'ElementSlideshow' => ElementSlideshow::class
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'Title',
    ];

    private static $default_sort = 'Sort';

    private static $owns = [
        'Image',
        'ElementLink'
    ];

    private static $cascade_deletes = [
        'Image',
        'ElementLink'
    ];

    private static $cascade_duplicates = [
        'Image',
        'ElementLink'
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->removeByName(['Sort', 'ElementSlideshowID', 'ElementLinkID']);
        
        $imageField = $fields->dataFieldByName('Image');
        if ($imageField) {
            $imageField->setFolderName('Uploads/Elements/Slideshow');
        }
        
        $contentField = $fields->dataFieldByName('Content');
        if ($contentField) {
            $contentField->setRows(6);
        }

        $fields->add(LinkField::create('ElementLink', 'Link'));

        return $fields;
    }
    public function getSlideImage()
    {
        return $this->Image();
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
