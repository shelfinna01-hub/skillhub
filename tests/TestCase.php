<?php

namespace Tests;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Helpers\TestHelpers;

/**
 * @property User $admin
 * @property User $peserta
 * @property Kelas $kelas
 */
abstract class TestCase extends BaseTestCase
{
    use TestHelpers;
}
