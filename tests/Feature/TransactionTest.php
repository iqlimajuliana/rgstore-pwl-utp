<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\TopupPackage;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Game $game;
    private TopupPackage $package;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $this->game = Game::create([
            'name' => 'Mobile Legends',
            'description' => 'MOBA game 5v5',
            'currency' => 'Diamonds',
            'is_active' => true,
        ]);

        $this->package = TopupPackage::create([
            'game_id' => $this->game->id,
            'amount' => '86 Diamonds',
            'price' => 20000,
            'is_active' => true,
        ]);
    }

    public function test_guest_cannot_access_checkout(): void
    {
        $response = $this->get(route('transactions.checkout'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_view_checkout_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('transactions.checkout'));
        $response->assertStatus(200);
        $response->assertSee('Form Top Up Game');
        $response->assertSee('Mobile Legends');
    }

    public function test_user_can_create_transaction(): void
    {
        $response = $this->actingAs($this->user)->post(route('transactions.store'), [
            'game_id' => $this->game->id,
            'package_id' => $this->package->id,
            'user_game_id' => '123456789',
            'zone_id' => '2023',
            'payment_method' => 'BCA',
        ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'game_id' => $this->game->id,
            'package_id' => $this->package->id,
            'user_game_id' => '123456789',
            'zone_id' => '2023',
            'payment_method' => 'BCA',
            'status' => 'pending',
            'amount' => '86 Diamonds',
            'total_price' => 20000,
        ]);

        $transaction = Transaction::where('user_id', $this->user->id)->first();
        $this->assertNotNull($transaction);
        $response->assertRedirect(route('transactions.payment', $transaction->id));
    }

    public function test_user_can_confirm_payment(): void
    {
        $transaction = Transaction::create([
            'invoice_code' => 'RGS-20261017-TEST1',
            'user_id' => $this->user->id,
            'game_id' => $this->game->id,
            'package_id' => $this->package->id,
            'user_game_id' => '123456789',
            'zone_id' => '2023',
            'payment_method' => 'QRIS',
            'amount' => '86 Diamonds',
            'total_price' => 20000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->post(route('transactions.pay', $transaction->id));

        $response->assertRedirect(route('transactions.show', $transaction->id));
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'success',
        ]);
    }

    public function test_user_can_cancel_pending_transaction(): void
    {
        $transaction = Transaction::create([
            'invoice_code' => 'RGS-20261017-TEST2',
            'user_id' => $this->user->id,
            'game_id' => $this->game->id,
            'package_id' => $this->package->id,
            'user_game_id' => '123456789',
            'payment_method' => 'DANA',
            'amount' => '86 Diamonds',
            'total_price' => 20000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->post(route('transactions.cancel', $transaction->id));

        $response->assertRedirect(route('transactions.history'));
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_user_can_view_transaction_history_and_detail(): void
    {
        $transaction = Transaction::create([
            'invoice_code' => 'RGS-20261017-TEST3',
            'user_id' => $this->user->id,
            'game_id' => $this->game->id,
            'package_id' => $this->package->id,
            'user_game_id' => '123456789',
            'payment_method' => 'GoPay',
            'amount' => '86 Diamonds',
            'total_price' => 20000,
            'status' => 'success',
        ]);

        $responseHistory = $this->actingAs($this->user)->get(route('transactions.history'));
        $responseHistory->assertStatus(200);
        $responseHistory->assertSee($transaction->invoice_code);

        $responseDetail = $this->actingAs($this->user)->get(route('transactions.show', $transaction->id));
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee($transaction->invoice_code);
        $responseDetail->assertSee('Pesanan Selesai');
    }
}
