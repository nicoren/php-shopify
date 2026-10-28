<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:45 AM UTC+06:00
 */

namespace PHPShopify;

class CustomCollectionTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "title" => "Macbooks",
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "title" => "Updated - Macbooks",
        "body_html" => "<p>The best selling Macbooks ever</p>",
    ];
}
