<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:43 AM UTC+06:00
 */

namespace PHPShopify;

class BlogTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "title" => "PHPShopify Test Blog",
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "title" => "PHPShopify Test Blog Modified",
    ];
}
