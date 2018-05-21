# Platform.sh Route Reader

Little library parsing and querying the Platform.sh routes. 

## Setup

```bash
$ composer require extremesensio/psh-route-reader
```

## Usage

When deploying on a PaaS, you might need to get the full URL
where your app gets deployed, e.g. Wordpress needs it to handled
multi-domain configuration.

On [Platform.sh](http://platform.sh) or [Sensiocloud](http://sensio.cloud)
these are available in an environment variable. This library allows
to easily query these, and their details, without having to
parse the environment variable.

```php
use Sensio\PshRouteReader\RouteReader;

$routeReader = new RouteReader();
$route = $routeReader->findOneByUpstream('app');

echo $route['full_url']; // "http://www.sensiogrey.com"
``` 

## On Sensiocloud

```php
use Sensio\PshRouteReader\RouteReader;

$routeReader = RouteReader::onSensiocloud();
$route = $routeReader->findOneByUpstream('app');

echo $route['full_url']; // "http://www.sensiogrey.com"
``` 
