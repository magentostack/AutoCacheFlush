<?php

declare(strict_types=1);

namespace Waqas\AutoCacheFlush\Observer;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\State;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Waqas\AutoCacheFlush\Helper\CacheFlushConfig as CacheFlushConfigHelper;
use Magento\Framework\Exception\LocalizedException;

class ControllerActionPredispatch implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var TypeListInterface
     */
    private $cacheTypeList;

    /**
     * @var CacheFlushConfigHelper
     */
    private $cacheFlushConfig;

    /**
     * @var State
     */
    private $state;

    /**
     * ControllerActionPredispatch constructor.
     * @param ManagerInterface $eventManager
     * @param MessageManagerInterface $messageManager
     * @param TypeListInterface $cacheTypeList
     * @param CacheFlushConfigHelper $cacheFlushConfig
     * @param State $state
     */
    public function __construct(
        ManagerInterface $eventManager,
        MessageManagerInterface $messageManager,
        TypeListInterface $cacheTypeList,
        CacheFlushConfigHelper $cacheFlushConfig,
        State $state
    ) {
        $this->eventManager = $eventManager;
        $this->messageManager = $messageManager;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFlushConfig = $cacheFlushConfig;
        $this->state = $state;
    }

    /**
     * Execute method for cleaning cache
     *
     * @param EventObserver $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(EventObserver $observer) : void
    {
        if ($this->cacheFlushConfig->isEnabledAutoCacheFlush()) {
            $invalidCaches = [];
            foreach ($this->cacheTypeList->getInvalidated() as $type) {
                $invalidCaches[] = $type->getId();
            }
            if ($invalidCaches) {
                $enabledCacheTypes = $this->cacheFlushConfig->getEnabledCacheTypes();
                $isCacheFlushed = false;
                foreach ($invalidCaches as $typeId) {
                    if (in_array($typeId, explode(',', $enabledCacheTypes))) {
                        $this->cacheTypeList->cleanType($typeId);
                        $isCacheFlushed = true;
                    }
                }
                $this->eventManager->dispatch('adminhtml_cache_flush_system');
                $this->messageManager->getMessages()->clear();
                if ($this->state->getAreaCode()==='adminhtml' && $isCacheFlushed) {
                    $this->messageManager->addSuccessMessage(__('Cache storage has been flushed automatically'));
                }
            }
        }
    }
}
