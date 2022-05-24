<?php declare(strict_types=1);

namespace StarringJane\MultiSelectSwatch\Observer;

use Magento\Framework\DataObject;
use Magento\Framework\Module\Manager;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use StarringJane\MultiSelectSwatch\Model\Swatch;

class AddMultiSelectSwatchType implements ObserverInterface
{
    protected Manager $moduleManager;

    public function __construct(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public function execute(EventObserver $observer): void
    {
        if (!$this->moduleManager->isOutputEnabled('StarringJane_MultiSelectSwatch')) {
            return;
        }

        /** @var DataObject $response */
        $response = $observer->getEvent()->getResponse();
        $types = $response->getTypes();
        $types[] = [
            'value' => Swatch::SWATCH_MULTISELECT_TYPE_VISUAL_ATTRIBUTE_FRONTEND_INPUT,
            'label' => __('Visual Swatch - Multiselect'),
            'hide_fields' => [
                'is_unique',
                'is_required',
                'frontend_class',
                '_scope',
                '_default_value',
            ],
        ];
        $types[] = [
            'value' => Swatch::SWATCH_MULTISELECT_TYPE_TEXTUAL_ATTRIBUTE_FRONTEND_INPUT,
            'label' => __('Text Swatch - Multiselect'),
            'hide_fields' => [
                'is_unique',
                'is_required',
                'frontend_class',
                '_scope',
                '_default_value',
            ],
        ];

        $response->setTypes($types);
    }
}
