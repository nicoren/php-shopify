<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:52 AM UTC+06:00
 */

namespace PHPShopify;

class SmartCollectionTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "title" => "Macbooks",
        "published" => false,
        "rules" => [
            [
                "column" => "vendor",
                "relation" => "equals",
                "condition" => "Apple",
            ],
        ],
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "body_html" => "<p>The best selling Macbooks ever</p>",
    ];
}
