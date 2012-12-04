<?php

use Igorw\CgiHttpKernel\CgiHttpKernel;
use Symfony\Component\HttpKernel\Client;

class phpbb_foo_test extends PHPUnit_Framework_TestCase
{
    public function test_index()
    {
        $kernel = new CgiHttpKernel(__DIR__.'/../phpBB');
        $client = new Client($kernel);

        $crawler = $client->request('GET', '/index.php');
        $this->assertGreaterThan(0, $crawler->filter('.topiclist')->count());
    }
}
