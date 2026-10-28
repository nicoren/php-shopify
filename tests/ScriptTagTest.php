<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/10/16 10:50 AM UTC+06:00
 */

namespace PHPShopify;

class ScriptTagTest extends TestSimpleResource
{
    /**
     * @inheritDoc
     */
    public $postArray = [
        "event" => "onload",
        "src" => "https://djavaskripped.org/fancy.js",
    ];

    /**
     * @inheritDoc
     */
    public $putArray = [
        "src" => "https://somewhere-else.com/another.js",
    ];
}
