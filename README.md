# Manrog Network Component Curl

[![Build Status](https://travis-ci.org/mrVictorios/manrog-compontents-network-curl.svg?branch=master)](https://travis-ci.org/mrVictorios/manrog-compontents-network-curl)

This component works as adapter for cURL in a OOP environment. It deliver a wrapper class wich contains the 
exactly methods of CURL and a UrlRequest class for creating a CURL request faster.

## Usage

Composer
```bash
    $ php composer.phar require manrog/network-component-curl
```

Curl example
```php
    <?php
    
    use manrog\components\network\curl\Curl;
    // get a wrapper instance
    $curl = new Curl();
    // create new cURL resource
    $ch   = $curl->init('http://www.example.com');
    // returns content on execute
    $curl->setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // grab URL and pass it to the browser
    $curl->exec($ch);
    // close cURL resource, and free up system resources
    $curl->close($ch);
```

UrlRequest
```php
    <?php
    
    use manrog\components\network\curl\UrlRequest;
    use manrog\components\network\curl\Curl;
    
    // get a comfort instance
    $rq = new UrlRequest('http://www.example.com', new Curl());
    // performs init, exec and close with CURLOPT_RETURNTRANSFER 1
    $rq->execute();
```
```php
    <?php
    
    use manrog\components\network\curl\UrlRequest;
    use manrog\components\network\curl\Curl;
    
    // get a comfort instance
    $rq = new UrlRequest('http://www.example.com', new Curl());
    $rq->addCurlOption(CURLOPT_RETURNTRANSFER, 1);
    //...
    $rq->execute();
```

## Install (for development)

Install for development and Validate the Project

```bash
    $ php ./env/files/install-composer.php
    $ php composer.phar install
    $ ./bin/phpunit -c phpunit.xml
```

### How get the documentation?

```bash
    $ ./bin/phploc --log-xml=./build/logs/phploc.xml ./src
    $ ./bin/phpdox
```
