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

    private static $db = [
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Sort' => 'Int',
    ];

    private static $has_one = array(
        'Image' => Image::class,
        'Link' => Link::class,
        'ElementSlideshow' => ElementSlideshow::class,
    );

    private static $summary_fields = array(
        'Image.CMSThumbnail',
        'Title',
    );

    private static $default_sort = 'Sort';


    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName(array(
                'Sort',
            ));

            $fields->replaceField(
                'LinkID',
                LinkField::create('LinkID', $this->fieldLabel('LinkID'))
                    ->setDescription(_t(__CLASS__ . '.LinkDescription', 'optional. Add a call to action link.'))
            );
            $fields->insertBefore($fields->dataFieldByName('LinkID'), 'Content');

            $image = $fields->dataFieldByName('Image')
                ->setDescription(_t(__CLASS__ . '.ImageDescription', 'optional. Display an image.'))
                ->setFolderName('Uploads/Elements/Objects');
            $fields->insertBefore($image, 'Content');

            $fields->dataFieldByName('Content')
                ->setRows(8);
        });

        return parent::getCMSFields();
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
