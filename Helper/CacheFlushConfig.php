<?php

declare(strict_types=1);

namespace Waqas\AutoCacheFlush\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class CacheFlushConfig extends AbstractHelper
{
    const ENABLED_FLUSH_CACHE   = 'auto_cache_flush/cache_flush_group/enabled_flush_cache';
    const ENABLED_FLUSH_CACHE_TYPES   = 'auto_cache_flush/cache_flush_group/cache_types';

    /**
     * Check if Auto Cache Flush Conf is enabled
     *
     * @return bool
     */
    public function isEnabledAutoCacheFlush() : bool
    {
        return $this->scopeConfig->isSetFlag(
            self::ENABLED_FLUSH_CACHE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get selected Cache Types
     *
     * @return string
     */
    public function getEnabledCacheTypes() : string
    {
        return $this->scopeConfig->getValue(
            self::ENABLED_FLUSH_CACHE_TYPES,
            ScopeInterface::SCOPE_STORE
        );
    }
}
