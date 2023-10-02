<?php

namespace Mouseketeers\Elements\Slideshow\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Mouseketeers\Elements\Slideshow\Model\ElementSlideshowSlide;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Assets\Image;


class ElementSlideshow extends BaseElement
{


    private static $singular_name = 'Slideshow';


    private static $plural_name = 'Slideshows';


    private static $description = 'Slideshow';


    private static $icon = 'font-icon-block-carousel';

    private static $table_name = 'ElementSlideshow';


    private static $db = [
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Image' => Image::class,
    ];

    private static $has_many = [
        'ElementSlideshowSlides' => ElementSlideshowSlide::class,
    ];


    private static $owns = [
        'ElementSlideshowSlides',
        'Image',
    ];

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @param bool $includerelations
     * @return array
     */
    // public function fieldLabels($includerelations = true)
    // {
    //     $labels = parent::fieldLabels($includerelations);

    //     // $labels['Content'] = _t(__CLASS__.'.ContentLabel', 'Intro');
    //     // $labels['Alternate'] = _t(__CLASS__ . '.AlternateLabel', 'Alternate Layout');
    //     // $labels['Features'] = _t(__CLASS__ . '.FeaturesLabel', 'Features');

    //     return $labels;
    // }

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setTitle($this->fieldLabel('Content'))
                ->setRows(5);

            // $alternate = $fields->dataFieldByName('Alternate');
            // $fields->removeByName('Alternate');

            // $fields->addFieldToTab(
            //     'Root.Main',
            //     CompositeField::create(
            //         $alternate
            //             ->setTitle($this->fieldLabel('Alternate'))
            //             ->setDescription(_t(
            //                 __CLASS__ . '.AlternateDescription',
            //                 'alternate image and text alignment - first feature: image left, copy right; 
            //                     second feature: image right, copy left;'
            //             ))
            //     )->setTitle(_t(
            //         __CLASS__ . '.LayoutLabel',
            //         'Layout'
            //     ))
            // );

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
        return _t(__CLASS__.'.BlockType', 'Slideshow / Carousel');
    }
}