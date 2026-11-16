<?php

namespace Tests\Feature;

use App\Mail\KodeOtp;
use App\Models\LoginOtp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\CreatesLibraryData;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use CreatesLibraryData, RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_login_sends_otp_and_requires_verification(): void
    {
        Mail::fake();

        $user = $this->makeUser('Pustakawan');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login.otp'));
        $this->assertGuest();
        $this->assertSame(1, LoginOtp::count());

        Mail::assertSent(KodeOtp::class, function (KodeOtp $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_correct_otp_logs_staff_in(): void
    {
        Mail::fake();

        $user = $this->makeUser('Admin');
        $code = $this->requestOtp($user);

        $response = $this->post(route('login.otp.verify'), ['code' => $code]);

        $response->assertRedirect(route('peminjaman.index'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotNull(LoginOtp::first()->consumed_at);
    }

    public function test_wrong_otp_does_not_login(): void
    {
        Mail::fake();

        $user = $this->makeUser('Pustakawan');
        $this->requestOtp($user);

        $response = $this->from(route('login.otp'))
            ->post(route('login.otp.verify'), ['code' => '000000']);

        $response->assertRedirect(route('login.otp'));
        $response->assertSessionHasErrors('code');
        $this->assertGuest();
        $this->assertSame(1, LoginOtp::first()->attempts);
    }

    public function test_otp_page_masks_the_email(): void
    {
        Mail::fake();

        $user = $this->makeUser('Pustakawan');
        $this->requestOtp($user);

        $response = $this->get(route('login.otp'));

        $response->assertOk();
        $response->assertDontSee($user->email);
        $response->assertSee('pu*********@example.test');
    }

    public function test_expired_otp_is_rejected(): void
    {
        Mail::fake();

        $user = $this->makeUser('Pustakawan');
        $code = $this->requestOtp($user);

        $this->travel((int) config('otp.ttl_minutes') + 1)->minutes();

        $response = $this->from(route('login.otp'))
            ->post(route('login.otp.verify'), ['code' => $code]);

        $response->assertRedirect(route('login.otp'));
        $response->assertSessionHasErrors('code');
        $this->assertGuest();
    }

    public function test_resend_is_rate_limited(): void
    {
        Mail::fake();

        $user = $this->makeUser('Pustakawan');
        $this->requestOtp($user);

        $response = $this->from(route('login.otp'))
            ->post(route('login.otp.resend'));

        $response->assertRedirect(route('login.otp'));
        $response->assertSessionHasErrors('code');
        $this->assertSame(1, LoginOtp::count());
    }

    public function test_login_fails_with_wrong_password_and_does_not_send_otp(): void
    {
        Mail::fake();

        $user = $this->makeUser('Admin');

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password-salah',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
        Mail::assertNothingSent();
        $this->assertSame(0, LoginOtp::count());
    }

    private function requestOtp($user): string
    {
        $code = '';

        Mail::assertNothingSent();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('login.otp'));

        Mail::assertSent(KodeOtp::class, function (KodeOtp $mail) use (&$code, $user) {
            $code = $mail->kode;

            return $mail->hasTo($user->email);
        });

        return $code;
    }
}
