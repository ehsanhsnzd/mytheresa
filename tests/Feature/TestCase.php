<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Throwable;
use Tests\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/**
 * Class TestCase
 * @package Tests\Feature
 */
class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setPrerequisites();
    }

}
