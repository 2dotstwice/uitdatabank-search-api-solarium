Proof of concept for using CultuurNet UiTdatabank [Search API v2](http://tools.uitdatabank.be/docs/search-api-v2-getting-started) through the
[Solarium](https://github.com/solariumphp/solarium) Solr client library for PHP.

# Usage examples
The _examples_ directory contains some relatively small command line apps demonstrating how
you can use this library. To try one of them, cd into its directory, run `composer install`
and then run `app.php`.

# Authentication

Solarium only provides support for basic HTTP authentication out of the box.
Search API v2 however uses OAuth 1. You can accomplish the necessary OAuth
authentication on a lower level though, in the actual HTTP client library that
is used by Solarium.

In our usage examples we use [Guzzle](http://docs.guzzlephp.org/en/latest/) with
the [Guzzle OAuth Subscriber](https://github.com/guzzle/oauth-subscriber).
