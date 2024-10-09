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
