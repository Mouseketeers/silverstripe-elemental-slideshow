<?php

namespace Mouseketeers\Elements\Slideshow;

use DNADesign\Elemental\Models\BaseElement;
use Mouseketeers\Elements\Slideshow\ElementSlideshowSlide;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class ElementSlideshow extends BaseElement
{

    private static $singular_name = 'Slideshow';
    private static $plural_name = 'Slideshows';
    private static $description = 'Slideshow';

    private static $icon = 'font-icon-block-carousel';

    private static $table_name = 'ElementSlideshow';

    private static $db = [
        'HTML' => 'HTMLText'
    ];

    private static $has_many = [
        'ElementSlideshowSlides' => ElementSlideshowSlide::class,
    ];

    private static $owns = [
        'ElementSlideshowSlides'
    ];

	private static array $cascade_deletes = [
        'ElementSlideshowSlides'
    ];    

    private static $inline_editable = false;

    public function getCMSFields()
    {
		$fields = parent::getCMSFields();
        if ($this->ID) {
            $fields->removeByName('ElementSlideshowSlides');

            $config = GridFieldConfig_RelationEditor::create();
            $config
                ->addComponent(new GridFieldOrderableRows('Sort'))
                ->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class
                ]);

            $slidesField = GridField::create(
                'ElementSlideshowSlides',
                'Slides',
                $this->ElementSlideshowSlides(),
                $config
            );
            
            $fields->addFieldToTab('Root.Main', $slidesField);
        }
        return $fields;
    }

    public function getSlideshowSlides()
    {
        return $this->ElementSlideshowSlides()->sort('Sort');
    }

    public function getSummary()
    {
        $count = $this->ElementSlideshowSlides()->count();
        if ((int)$count === 1) {
            $label = _t(
                ElementSlideshowSlide::class . '.SINGULAR',
                'One Slideshow Slide'
            );
        } else {
            $label = sprintf(
                _t(
                    ElementSlideshowSlide::class . '.PLURAL',
                    '%s Slideshow Slides'
                ),
                $count
            );
        }

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