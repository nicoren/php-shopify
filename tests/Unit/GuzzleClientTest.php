<?php

namespace PHPShopify\Tests\Unit;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPShopify\Config;
use PHPShopify\GuzzleClient;
use PHPUnit\Framework\TestCase;

class GuzzleClientTest extends TestCase
{
    private const URL = 'https://shop.myshopify.com/admin/api/2025-01/shop.json';

    private MockHandler $mock;

    /**
     * @var array<int, array<string, mixed>>
     */
    private array $history = [];

    /**
     * @param Response[] $responses
     * @param array<string, mixed> $config
     */
    private function createClient(array $responses, array $config = []): GuzzleClient
    {
        $this->mock = new MockHandler($responses);
        $this->history = [];
        $handler = HandlerStack::create($this->mock);
        $handler->push(Middleware::history($this->history));

        return new GuzzleClient(new Config('shop.myshopify.com', array_merge(['AccessToken' => 'token', 'handler' => $handler], $config), '2025-01'));
    }

    private function tooManyRequests(): Response
    {
        return new Response(429, ['Retry-After' => '0']);
    }

    public function testRetryAfterTooManyRequests(): void
    {
        $client = $this->createClient([$this->tooManyRequests(), $this->tooManyRequests(), new Response(200, [], '{}')]);

        $this->assertSame(200, $client->get(self::URL)->getStatusCode());
        $this->assertCount(3, $this->history);
    }

    public function testRetriesAreLimited(): void
    {
        $client = $this->createClient(array_fill(0, GuzzleClient::MAX_RETRIES + 5, $this->tooManyRequests()));

        try {
            $client->get(self::URL);
            $this->fail('The 429 error should be thrown after the last retry');
        } catch (ClientException $e) {
            $this->assertSame(429, $e->getCode());
        }
        $this->assertCount(GuzzleClient::MAX_RETRIES + 1, $this->history);
    }

    public function testOtherErrorsAreNotRetried(): void
    {
        $client = $this->createClient([new Response(404), new Response(200)]);

        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);
        try {
            $client->get(self::URL);
        } finally {
            $this->assertCount(1, $this->history);
        }
    }

    public function testDefaultTimeouts(): void
    {
        $client = $this->createClient([new Response(200)]);
        $client->get(self::URL);

        $this->assertSame(GuzzleClient::CONNECT_TIMEOUT, $this->history[0]['options']['connect_timeout']);
        $this->assertSame(GuzzleClient::TIMEOUT, $this->history[0]['options']['timeout']);
    }

    public function testConfiguredTimeouts(): void
    {
        $client = $this->createClient([new Response(200)], ['connect_timeout' => 3, 'timeout' => 30]);
        $client->get(self::URL);

        $this->assertSame(3, $this->history[0]['options']['connect_timeout']);
        $this->assertSame(30, $this->history[0]['options']['timeout']);
    }
}
