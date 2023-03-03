<?php

declare(strict_types=1);

namespace Waqas\AutoCacheFlush\Model\Config\Source;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Data\OptionSourceInterface;

class CacheTypes implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * @var TypeListInterface
     */
    private $cacheTypeList;

    /**
     * CacheTypes constructor.
     *
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(
        TypeListInterface $cacheTypeList
    ) {
        $this->cacheTypeList = $cacheTypeList;
    }

    /**
     * Get Option Array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if (empty($this->options)) {
            $cacheTypeList = $this->cacheTypeList->getTypes();
            foreach ($cacheTypeList as $cacheType) {
                $this->options[] = [
                    'value' => $cacheType->getId(),
                    'label' => $cacheType->getCacheType()
                ];
            }
        }
        return $this->options;
    }
}
