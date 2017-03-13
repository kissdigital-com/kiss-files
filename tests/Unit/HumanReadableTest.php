<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HumanReadableTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConversion()
    {
        $result = \App\Helpers\HumanReadable::bytesToHuman(0);
        $this->assertTrue($result === '0 bytes');

        $result = \App\Helpers\HumanReadable::bytesToHuman(100);
        $this->assertTrue($result === '100 bytes');

        $result = \App\Helpers\HumanReadable::bytesToHuman(1536);
        $this->assertTrue($result === '1.5 kB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(2000);
        $this->assertTrue($result === '2 kB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(500000);
        $this->assertTrue($result === '488.3 kB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(3670016);
        $this->assertTrue($result === '3.5 MB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(262144000);
        $this->assertTrue($result === '250 MB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(7516192768);
        $this->assertTrue($result === '7 GB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(123456789012, 2);
        $this->assertTrue($result === '114.98 GB');

        $result = \App\Helpers\HumanReadable::bytesToHuman(1099511627776);
        $this->assertTrue($result === '1 TB');
    }
}
