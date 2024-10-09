# Interview Task: NYT API

## Setup

_This assumes you already have docker installed on your system_

_There is a Makefile for your convenience_

-   Copy the env example over: `cp .env.example .env`
-   Add your environment variables to the `.env` file including your api key and base_uri
-   Initialize the project: `make init`.
-   Hop into a container: `docker compose exec app bash` or alternatively you can run: `make shell` to exec into the container

## Running Tests

-   After getting into the app container you can run: `php artisan test` to run the entire test suite (once again, these tests should be run from within the container)
-   The tests use an HTTP fake and stubs along with a simplified read-through cache to simulate behavior and therefore do not hit the NYT api but the responses are legitimate json responses

## Suggested Improvements

-   The responses from the NYT api could probably be massaged into some DTO but we're just spitting out json from the NYT api.
-   There's some repetition in the tests that we could have refactored into a helper. I'm thinking of how we test each endpoint twice: once for a non-cached response and a second time to ensure the cache is hit.
-   We could probably add a config setting to not bind the cache in the service container. It's possible that someone may not want that.
-   Speaking of caching, we're using a form of content hashing and time based invalidation, but it's possible someone may want to configure different caching strategies as well as cache-invalidation strategies. This could be conditionally bound to the interface in the service provider.
-   Instead of using stubs, it may have been nicer to create a builder for the various tests but there just aren't that many tests to justify it.
-   Since the api is only exposing one endpoint that's essentially versioned, there isn't any enforcement of versioning beyond this.
