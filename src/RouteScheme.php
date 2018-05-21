<?php

namespace Sensio\PshRouteReader;

/**
 * Enum allowing to filter by scheme
 */
class RouteScheme
{
    /**
     * @const Filter by allowing only HTTPS routes
     */
    const HTTPS = 'https';

    /**
     * @const Filter by allowing only HTTP routes
     */
    const HTTP = 'http';

    /**
     * @const Filter by allowing any scheme (HTTP or HTTPS).
     */
    const ANY = 'any';
}
