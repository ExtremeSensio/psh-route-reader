<?php

namespace Sensio\PshRouteReader;

use Platformsh\ConfigReader\Config;
use Sensio\PshRouteReader\RouteScheme;

class RouteReader
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config !== null ? $config : new Config();
    }

    /**
     * Factory method, configuring this Reader for a use on Sensiocloud.
     * @param null $environmentVariables
     * @return RouteReader
     */
    public static function onSensiocloud($environmentVariables = null)
    {
        $config = new Config($environmentVariables, 'SENSIOCLOUD_');

        return new self($config);
    }

    private function addFullUrl($routes)
    {
        return array_map(function($key, $value) {
            $value['full_url'] = $key;
            return $value;
        }, array_keys($routes), $routes);
    }

    public function findByUpstream($upstreamName, $httpsFilter = RouteScheme::ANY)
    {
         return $this->addFullUrl(array_filter(
             $this->config->routes,
             function($route) use ($upstreamName) {
                 return $route['type'] === 'upstream' && $route['upstream'] === $upstreamName;
             }
         ));
    }

    /**
     * @param $upstreamName
     * @param string $httpsFilter
     * @return array
     */
    public function findOneByUpstream($upstreamName, $httpsFilter = RouteScheme::ANY)
    {
        $matches = $this->findByUpstream($upstreamName, $httpsFilter);

        if (count($matches) !== 1) {
            $msg = sprintf(
                'Expected exactly 1 match on upstream "%s", but %d found.',
                $upstreamName,
                count($matches)
            );
            throw new \RuntimeException($msg);
        }

        return current($matches);
    }
}
