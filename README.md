# Clearpay PHP API Client

PHP library for Clearpay payments API v2

## Development

Copy `.env.dist` to `.env` and populate with your environment credentials. 

### Docker container

Optional development container.

```
docker-compose up -d --build
```

Accessing the container and running the test suite.

```
docker-compose run --rm -u build app bash
composer test
```

The Afterpay popup window can be used with the `webserver` container and tunnelled via ngrok. Use the below command to find your ngrok URL.

```
docker-compose logs -f ngrok
```

## Usage

Your project must implement the `\Inviqa\Clearpay\Config` class populated with your unique credentials.

```php
$app = new \Inviqa\Clearpay\Application(new \My\Payment\Configuration);
```

See examples directory for supported API endpoints.

