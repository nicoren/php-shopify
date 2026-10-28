<?php

namespace PHPShopify;

class ReportTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "name" => "A new app report",
        "shopify_ql" => "SHOW total_sales BY country FROM order SINCE -1m UNTIL today ORDER BY total_sales",
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "name" => "A new app report - updated",
    ];
}
