<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintTest extends TestCase
{
    use RefreshDatabase;

    public function test_complaint_has_an_owner_and_open_default_status(): void
    {
        $user = User::create([
            'name' => 'Complaint Owner',
            'email' => 'complaint-owner@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $complaint = $user->complaints()->create([
            'subject' => 'Top up belum masuk',
            'message' => 'Pembayaran berhasil, tetapi item belum diterima.',
        ]);

        $complaint = $complaint->fresh();

        $this->assertSame('open', $complaint->status);
        $this->assertTrue($complaint->user->is($user));
        $this->assertTrue($user->complaints->contains($complaint));
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'user_id' => $user->id,
            'transaction_id' => null,
            'status' => 'open',
        ]);
    }
}
