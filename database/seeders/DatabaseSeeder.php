<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contract;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tenant::factory()->create([
            'id'   => 1,
            'name' => 'Test Tenant1',
        ]);
        Tenant::factory()->create([
            'id'   => 2,
            'name' => 'Test Tenant2',
        ]);
        User::factory()->create([
            'name'      => 'Test User1',
            'email'     => 'user1@user.com',
            'tenant_id' => 1,
        ]);
        User::factory()->create([
            'name'      => 'Test User2',
            'email'     => 'user2@user.com',
            'tenant_id' => 2,
        ]);
        Contract::factory(10)->create();

    }
}
