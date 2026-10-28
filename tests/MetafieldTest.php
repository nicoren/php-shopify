<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:48 AM UTC+06:00
 */

namespace PHPShopify;

class MetafieldTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "namespace" => "inventory",
        "key" => "warehouse",
        "value" => 25,
        "value_type" => "integer",
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "value" => "something new",
        "value_type" => "string",
    ];
}
