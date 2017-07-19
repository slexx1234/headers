<?php

use PHPUnit\Framework\TestCase;

use Slexx\Headers\Headers;

class HeadersTest extends TestCase
{
    const TEST_HEADERS = [
        'Content-Type' => 'image/jpeg',
        'Accept-Charset' => 'utf-8',
        'X-My-Custom-Header' => 'Zeke are cool'
    ];

    public function testParse()
    {
        $this->assertEquals(self::TEST_HEADERS, Headers::parse(<<<EOT
Content-Type: image/jpeg
Accept-Charset: utf-8
X-My-Custom-Header: Zeke are cool
EOT
));
        $this->assertEquals(self::TEST_HEADERS, Headers::parse([
            'Content-Type: image/jpeg',
            'Accept-Charset: utf-8',
            'X-My-Custom-Header: Zeke are cool'
        ]));

        $this->assertEquals(self::TEST_HEADERS, Headers::parse(self::TEST_HEADERS));
    }

    public function testGet()
    {
        $headers = new Headers(self::TEST_HEADERS);
        $this->assertEquals('image/jpeg', $headers->get('Content-Type'));
        $this->assertEquals('Zeke are cool', $headers->get('X-My-Custom-Header'));
        $this->assertNull($headers->get('Other-Header'));
    }

    public function testRemove()
    {
        $headers = new Headers(self::TEST_HEADERS);
        $this->assertEquals('image/jpeg', $headers->get('Content-Type'));
        $headers->remove('Content-Type');
        $this->assertNull($headers->get('Content-Type'));
    }

    public function testHas()
    {
        $headers = new Headers(self::TEST_HEADERS);
        $this->assertTrue($headers->has('Content-Type'));
        $headers->remove('Content-Type');
        $this->assertFalse($headers->has('Content-Type'));
    }

    public function testSet()
    {
        $headers = new Headers(self::TEST_HEADERS);
        $this->assertEquals('image/jpeg', $headers->get('Content-Type'));
        $headers->set('Content-Type', 'image/gif');
        $this->assertEquals('image/gif', $headers->get('Content-Type'));
    }

    public function testToString()
    {
        $this->assertEquals("Content-Type: image/jpeg\nAccept-Charset: utf-8\nX-My-Custom-Header: Zeke are cool", (new Headers(self::TEST_HEADERS))->__toString());
    }

    public function testToArray()
    {
        $this->assertEquals(self::TEST_HEADERS, (new Headers(self::TEST_HEADERS))->toArray());
    }

    public function testCount()
    {
        $headers = new Headers(self::TEST_HEADERS);
        $this->assertEquals(3, count($headers));
        $headers->remove('Content-Type');
        $this->assertEquals(2, count($headers));
    }
}

