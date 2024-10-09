# Interview Task: NYT API

## Setup

_This assumes you already have docker installed on your system_

-   Copy the env example over: `cp .env.example .env`
-   Add your environment variables to the `.env` file including your api key and base_uri
-   Start the docker containers: `docker compose up -d`
-   Hop into a container: `docker compose exec app bash`

## Running Tests

-   After getting into the app container you can run: `php artisan test` to run the entire test suite
-   The tests use an HTTP fake and stubs to simulate behavior and therefore do not hit the NYT api but the responses are legitimate json responses
