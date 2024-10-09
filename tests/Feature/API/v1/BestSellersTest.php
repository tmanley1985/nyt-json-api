<?php

namespace Tests\Feature\API\v1;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BestSellersTest extends TestCase
{
    const BASE_NYT_API_URL = 'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json';

    #[Test]
    public function it_should_fail_validation_if_offset_is_invalid(): void
    {

        Http::fake();

        // The offset must be a multiple of 20 or 0!
        $response = $this->getJson('/api/1/nyt/best-sellers?offset=31');
        $response->assertStatus(422);

        // The offset cannot be a string value!
        $response = $this->getJson('/api/1/nyt/best-sellers?offset=thisAintNoNumber');
        $response->assertStatus(422);

        Http::assertNothingSent();
    }

    #[Test]
    public function it_should_fail_validation_if_isbns_are_of_invalid_length(): void
    {

        Http::fake();

        // ISBN lengths must be either 10 or 13 characters long!
        $response = $this->getJson('/api/1/nyt/best-sellers?isbn[]=01234567892');
        $response->assertStatus(422);

        $response = $this->getJson('/api/1/nyt/best-sellers?isbn[]=0123456789&isbn[]=0');
        $response->assertStatus(422);

        Http::assertNothingSent();
    }

    #[Test]
    public function it_should_fail_validation_if_string_params_are_invalid(): void
    {

        Http::fake();

        // The author and title must be strings. The query params will be parsed
        // as strings so we have a custom validation rule that ensures that they aren't numeric.
        $response = $this->getJson('/api/1/nyt/best-sellers?author=01234567892');
        $response->assertStatus(422);

        $response = $this->getJson('/api/1/nyt/best-sellers?title=01234567892');
        $response->assertStatus(422);

        Http::assertNothingSent();
    }

    #[Test]
    public function it_should_return_bestsellers_if_no_options_are_sent(): void
    {

        Http::fake();

        // The author and title must be strings. The query params will be parsed
        // as strings so we have a custom validation rule that ensures that they aren't numeric.
        $response = $this->getJson('/api/1/nyt/best-sellers?author=01234567892');
        $response->assertStatus(422);

        Http::assertNothingSent();
    }

    #[Test]
    public function it_should_return_401_if_no_api_key_is_sent_or_invalid(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_error_response_invalid_api_key.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 401),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers');

        $response->assertStatus(401);
    }

    #[Test]
    public function it_should_return_400_if_invalid_param_is_sent(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_error_response_invalid_parameter.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 400),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers');

        $response->assertStatus(500);
    }

    #[Test]
    public function it_should_return_data_if_no_params_sent(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_successful_response_no_params.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 200),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers');

        $response->assertJson(json_decode($stubbedResponse, true));

        Http::assertSent(function ($request) {
            $baseUrl = Str::before($request->url(), '?');

            return $baseUrl == self::BASE_NYT_API_URL
                && $request['api-key'] === config('services.nyt.api_key');
        });
    }

    #[Test]
    public function it_should_return_data_if_filtered_by_author(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_successful_response_by_author.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 200),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers?author=Stephen%20King');

        $response->assertJson(json_decode($stubbedResponse, true));

        Http::assertSent(function ($request) {
            $baseUrl = Str::before($request->url(), '?');

            return $baseUrl == self::BASE_NYT_API_URL
                && $request['api-key'] === config('services.nyt.api_key')
                && $request['author'] === 'Stephen King';
        });
    }

    #[Test]
    public function it_should_return_data_if_filtered_by_title(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_successful_response_by_title.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 200),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers?title=CELL');

        $response->assertJson(json_decode($stubbedResponse, true));

        Http::assertSent(function ($request) {
            $baseUrl = Str::before($request->url(), '?');

            return $baseUrl == self::BASE_NYT_API_URL
                && $request['api-key'] === config('services.nyt.api_key')
                && $request['title'] === 'CELL';
        });
    }

    #[Test]
    public function it_should_return_data_by_offset(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_successful_response_by_offset_100.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 200),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers?offset=100');

        $response->assertJson(json_decode($stubbedResponse, true));

        Http::assertSent(function ($request) {
            $baseUrl = Str::before($request->url(), '?');

            return $baseUrl == self::BASE_NYT_API_URL
                && $request['api-key'] === config('services.nyt.api_key')
                && $request['offset'] === 100;
        });
    }

    #[Test]
    public function it_should_return_data_by_single_isbn(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_successful_response_by_single_isbn.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 200),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers?isbn[]=1401228305');

        $response->assertJson(json_decode($stubbedResponse, true));

        Http::assertSent(function ($request) {
            $baseUrl = Str::before($request->url(), '?');

            return $baseUrl == self::BASE_NYT_API_URL
                && $request['api-key'] === config('services.nyt.api_key')
                && $request['isbn'] === '1401228305';
        });
    }

    #[Test]
    public function it_should_return_data_by_multiple_isbns(): void
    {

        $stubbedResponse = File::get(base_path('tests/stubs/nyt_successful_response_by_multiple_isbns.json'));

        Http::fake([
            'api.nytimes.com/*' => Http::response($stubbedResponse, 200),
        ]);

        $response = $this->getJson('/api/1/nyt/best-sellers?isbn[]=1401228305&isbn[]=9780316015844');

        $response->assertJson(json_decode($stubbedResponse, true));

        Http::assertSent(function ($request) {
            $baseUrl = Str::before($request->url(), '?');

            return $baseUrl == self::BASE_NYT_API_URL
                && $request['api-key'] === config('services.nyt.api_key')
                && $request['isbn'] === '1401228305;9780316015844';
        });
    }
}
