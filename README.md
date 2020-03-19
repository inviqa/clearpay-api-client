# Clearpay PHP API Client

PHP library for Clearpay payments API v2

## Development

Copy `.env.dist` to `.env` and populate with your environment credentials. 

### Docker container

Optional development container.

```
docker-compose up -d
```

Accessing the container and running the test suite.

```
docker-compose run --rm -u build app bash
composer test
```


## Usage

Your project must implement the `\Inviqa\Clearpay\Config` class populated with your unique credentials.

```php
$app = new \Inviqa\Clearpay\Application(new \My\Payment\Configuration);
```

See examples directory for supported API endpoints.

