<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:49 AM UTC+06:00
 */

namespace PHPShopify;

class PageTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "title" => "Warranty information",
        "body_html" => "<h1>Warranty<\/h1>\n<p><strong>Forget it<\/strong>, we aint giving you nothing<\/p>",
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "title" => "Updated Warranty information",
    ];
}
