<?php

namespace Smile\RetailerOffer\Ui\Component\Offer\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;


class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
        ) {
            $this->urlBuilder = $urlBuilder;
            parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $editUrlPath        = $this->getData('config/editUrlPath') ?: '#';
        $deleteUrlPath      = $this->getData('config/deleteUrlPath') ?: '#';
        $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'id';
        $indexFieldName     = $this->getData('config/indexField') ?: 'offer_id';

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$indexFieldName])) {
                    $offerId   = $item[$indexFieldName];
                    $editUrl   = $this->urlBuilder->getUrl($editUrlPath, [$urlEntityParamName => $offerId]);
                    $deleteUrl = $this->urlBuilder->getUrl($deleteUrlPath, [$urlEntityParamName => $offerId]);
                    $item[$this->getData('name')] = [
                        'edit'   => ['href' => $editUrl, 'label' => __('Edit')],
                        'delete' => ['href' => $deleteUrl, 'label' => __('Delete')]
                    ];
                }
            }
        }

        return $dataSource;
    }
}