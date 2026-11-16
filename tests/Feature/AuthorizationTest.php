<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesLibraryData;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use CreatesLibraryData, RefreshDatabase;

    public function test_pustakawan_cannot_access_user_management(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');

        $this->actingAs($pustakawan)->get(route('user.index'))->assertForbidden();
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = $this->makeUser('Admin');

        $this->actingAs($admin)->get(route('user.index'))->assertOk();
    }

    public function test_admin_cannot_create_loan(): void
    {
        $admin = $this->makeUser('Admin');

        $this->actingAs($admin)->get(route('peminjaman.create'))->assertForbidden();
        $this->actingAs($admin)->post(route('peminjaman.store'), [])->assertForbidden();
    }

    public function test_admin_cannot_process_return(): void
    {
        $admin = $this->makeUser('Admin');

        $this->actingAs($admin)->post(route('pengembalian.store'), [])->assertForbidden();
    }

    public function test_pustakawan_can_open_loan_form(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');

        $this->actingAs($pustakawan)->get(route('peminjaman.create'))->assertOk();
    }
}
