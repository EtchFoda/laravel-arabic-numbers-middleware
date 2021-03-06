<?php

namespace Yemenifree\LaravelArabicNumbersMiddleware\Test;

use Yemenifree\LaravelArabicNumbersMiddleware\Middleware\TransformArabicToEasternNumbers;

class ArabicMiddlewareTest extends TestCase
{
    /** @test */
    public function it_will_transform_numbers_to_eastern_with_auto_append_middleware()
    {
        $this->post('login-arabic-to-eastern-auto-append', $this->arabicTestData)->assertJson($this->easternTestData);
    }

    /** @test */
    public function it_will_transform_numbers_to_eastern_with_manual_append_middleware()
    {
        $this->post('login-arabic-to-eastern', $this->arabicTestData)->assertJson($this->easternTestData);
    }

    /** @test */
    public function it_will_skip_transform_numbers_to_eastern_with_ignore_fields_from_config()
    {
        $this->app['config']->set('arabic-numbers-middleware.except_from_arabic_to_eastern', ['pass']);
        $this->post('login-arabic-to-eastern-auto-append', $this->arabicTestData)->assertJson($this->ignoreTestData);
    }

    /** @test */
    public function it_will_skip_transform_numbers_to_eastern_with_ignore_field_as_global()
    {
        $this->app['config']->set('arabic-numbers-middleware.except_from_all', ['pass']);
        $this->post('login-arabic-to-eastern-auto-append', $this->arabicTestData)->assertJson($this->ignoreTestData);
    }

    /** @test */
    public function it_will_skip_transform_numbers_to_eastern_with_ignore_fields_from_inline()
    {
        $this->refreshApp(false);
        $this->post('login-arabic-to-eastern-ignore-pass-field-inline', $this->arabicTestData)->assertJson($this->ignoreTestData);
    }

    /** @test */
    public function it_will_not_transform_numbers_to_eastern_without_auto_append_middleware()
    {
        $this->refreshApp(false);
        $this->post('login-arabic-to-eastern-auto-append', $this->arabicTestData)->assertExactJson($this->arabicTestData);
    }

//    /** @test */
//    public function it_will_transform_numbers_to_eastern_with_auto_append_middleware_to_route_group()
//    {
//        $this->refreshApp(['web']);
//        $this->post('login-arabic-to-eastern-auto-append-to-route-group', $this->arabicTestData)->assertExactJson($this->easternTestData);
//    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('arabic-numbers-middleware.auto_middleware', TransformArabicToEasternNumbers::class);
    }
}
