<?php

namespace Sensio\PshRouteReader\Tests;

use Sensio\PshRouteReader\RouteReader;

class RouteReaderTest extends \PHPUnit_Framework_TestCase
{
    private function getReader()
    {
        return RouteReader::onSensiocloud([
            'SENSIOCLOUD_ROUTES' => base64_encode(file_get_contents(__DIR__.'/data/routes.json')),
        ]);
    }

    private function getHttpsReader()
    {
        return RouteReader::onSensiocloud([
            'SENSIOCLOUD_ROUTES' => base64_encode(file_get_contents(__DIR__.'/data/routes_https_only.json')),
        ]);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_it_throws_an_exception_when_no_upstream_is_found()
    {
        $this->getReader()->findOneByUpstream('non-existent');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_it_throws_an_exception_when_too_many_upstream_are_found()
    {
        $this->getReader()->findOnebyUpstream('website');
    }

    public function test_it_filters_by_upstream()
    {
        $results = $this->getReader()->findByUpstream('website');

        $this->assertEquals(2, count($results));
    }

    public function test_it_can_find_one_and_only_one_route_by_upstream()
    {
        $results = $this->getHttpsReader()->findOneByUpstream('website');

        $this->assertEquals($results['type'], 'upstream');
        $this->assertEquals($results['upstream'], 'website');
    }

    public function test_it_add_the_absolute_url_in_the_returned_array()
    {
        $results = $this->getHttpsReader()->findOneByUpstream('website');

        $this->assertEquals($results['full_url'], 'https://www.sensiogrey.com/');
    }
}
