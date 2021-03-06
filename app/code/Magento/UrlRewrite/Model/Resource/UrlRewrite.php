<?php
/**
 * URL rewrite resource model
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\UrlRewrite\Model\Resource;

class UrlRewrite extends \Magento\Framework\Model\Resource\Db\AbstractDb
{
    /**
     * Define main table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('url_rewrite', 'url_rewrite_id');
    }

    /**
     * Initialize array fields
     *
     * @return $this
     */
    protected function _initUniqueFields()
    {
        $this->_uniqueFields = [
            ['field' => ['request_path', 'store_id'], 'title' => __('Request Path for Specified Store')],
        ];
        return $this;
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param \Magento\UrlRewrite\Model\UrlRewrite $object
     * @return \Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        /** @var $select \Magento\Framework\DB\Select */
        $select = parent::_getLoadSelect($field, $value, $object);

        if (!is_null($object->getStoreId())) {
            $select->where(
                'store_id IN(?)',
                [\Magento\Store\Model\Store::DEFAULT_STORE_ID, $object->getStoreId()]
            );
            $select->order('store_id ' . \Magento\Framework\DB\Select::SQL_DESC);
            $select->limit(1);
        }

        return $select;
    }
}
