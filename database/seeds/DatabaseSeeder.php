<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(ProdukSeeder::class);
        $this->call(TestimoniSeeder::class);
        $this->call(MitraSeeder::class);
        $this->call(SettingPerusahaanSeeder::class);
        $this->call(BankSeeder::class);
    }
}
