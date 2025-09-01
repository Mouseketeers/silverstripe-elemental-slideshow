<?php

namespace Mouseketeers\Elements\Slideshow;

use DNADesign\Elemental\Models\BaseElement;
use Mouseketeers\Elements\Slideshow\ElementSlideshowSlide;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


class ElementSlideshow extends BaseElement
{

    private static $singular_name = 'Slideshow';
    private static $plural_name = 'Slideshows';
    private static $description = 'Slideshow';

    private static $icon = 'font-icon-block-carousel';

    private static $table_name = 'ElementSlideshow';

    private static $has_many = [
        'ElementSlideshowSlides' => ElementSlideshowSlide::class,
    ];

    private static $owns = [
        'ElementSlideshowSlides'
    ];

    private static $inline_editable = false;

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            if ($this->ID) {
                $items = $fields->dataFieldByName('ElementSlideshowSlides');
                $fields->removeByName('ElementSlideshowSlides');

                $config = $items->getConfig();
                $config
                    ->addComponent(new GridFieldOrderableRows())
                    ->removeComponentsByType([
                        GridFieldAddExistingAutocompleter::class,
                        GridFieldDeleteAction::class
                    ]);

                $fields->addFieldToTab('Root.Main', $items);
            }
        });

        return parent::getCMSFields();
    }

    public function getSlideshowSlides()
    {
        return $this->ElementSlideshowSlides()->sort('Sort');
    }

    public function getSummary()
    {
        $count = $this->ElementSlideshowSlides()->count();
        $label = _t(
            ElementSlideshowSlide::class . '.PLURALS',
            'One Slideshow Slide |{count} Slideshow Slides',
            [ 'count' => $count ]
        );
        return DBField::create_field('HTMLText', $label)->Summary(20);
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'Slideshow');
    }
}