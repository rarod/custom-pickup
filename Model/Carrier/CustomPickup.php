<?php
declare(strict_types=1);

namespace Rarod\CustomPickup\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

/**
 * Class CustomPickup
 * @package Rarod\CustomPickup\Model\Carrier
 */
class CustomPickup extends AbstractCarrier implements CarrierInterface
{
    /**
     * Shipping code
     */
    const SHIPPING_CODE = 'custompickup';

    /**
     * @var string
     */
    public $_code = self::SHIPPING_CODE;

    /**
     * @var ResultFactory
     */
    public ResultFactory $rateResultFactory;

    /**
     * @var MethodFactory
     */
    public MethodFactory $rateMethodFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return [self::SHIPPING_CODE => $this->getConfigData('name')];
    }

    /**
     * @param RateRequest $request
     * @return bool|Result
     * @noinspection PhpUndefinedMethodInspection
     */
    public function collectRates(RateRequest $request): Result|bool
    {
        if (!$this->getActiveFlag()) {
            return false;
        }

        $result = $this->rateResultFactory->create();
        $shippingPrice = $this->getConfigData('price');
        /** @var Method $method */
        $method = $this->rateMethodFactory->create()
            ->setCarrier(self::SHIPPING_CODE)
            ->setCarrierTitle($this->getConfigData('title'))
            ->setMethod(self::SHIPPING_CODE)
            ->setMethodTitle($this->getConfigData('name'))
            ->setPrice($shippingPrice)
            ->setCost($shippingPrice);
        $result->append($method);
        return $result;
    }
}