# Changelog

## 2.1.1

### Fixes

- `GuzzleClient`: the requests have a timeout (`connect_timeout` 10 s, `timeout` 120 s by default, configurable
  with the `connect_timeout` and `timeout` keys of the SDK config). Without it a stalled connection blocked forever.
- `GuzzleClient`: the retry on HTTP 429 is limited to 10 attempts and waits the `Retry-After` delay (1 s by default)
  instead of 0.5 ms, it could loop forever.

## 2.1.0

- PHP 8.2 or above (tested with PHP 8.5).
- `guzzlehttp/guzzle` (^7.10) is declared as a dependency: the HTTP calls are made with Guzzle since 2.0.
- `Config::__construct()`: the `$config` argument has no default value anymore
  (an optional parameter before a required one is deprecated since PHP 8.0).
- PHPUnit 12 as development dependency.

Note: the default API version of `ShopifySDK` is still `2020-01`, a version retired by Shopify which serves
the oldest supported version instead. Pass an explicit supported version as third argument of `ShopifySDK`
(see https://shopify.dev/docs/api/usage/versioning).
