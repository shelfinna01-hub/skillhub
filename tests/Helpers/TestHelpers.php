<?php

namespace Tests\Helpers;

use App\Models\Kelas;
use App\Models\User;

/**
 * Trait for test helpers that define common test properties
 */
trait TestHelpers
{
    /**
     * @var User
     */
    public $admin;

    /**
     * @var User
     */
    public $peserta;

    /**
     * @var Kelas
     */
    public $kelas;
}


