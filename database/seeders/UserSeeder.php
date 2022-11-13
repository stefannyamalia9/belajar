<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $user = [
                [
                    'name' => 'Ahmad Badruzzaman',
                    'username' => 'ahmadbadruzzaman',
                    'password' => Hash::make('password'),
                    'isguru' => true,
                ],
                [
                    'name' => 'Mubarok Izzaturrohman',
                    'username' => 'mubarokizzaturrohman',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'M. Raisya Fauz',
                    'username' => 'mraisyafauzi',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'Arslan Wirya Ismail',
                    'username' => 'arslanwiryaismail',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'M. Nafis F',
                    'username' => 'mnafisf',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'Bara Fatih Arkan',
                    'username' => 'barafatiharkan',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'M. Afif Madani',
                    'username' => 'mafifmadani',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'Lav Raya Z',
                    'username' => 'lavrayaz',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'M. Dandra Abyan',
                    'username' => 'mdandraabyan',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ],
                [
                    'name' => 'M. Irham Faras',
                    'username' => 'mirhamfaras',
                    'password' => Hash::make('password'),
                    'isguru' => false,
                ]
            ];

            foreach ($user as $item) {
                User::create([
                    'name' => $item['name'],
                    'username' => $item['username'],
                    'password' => $item['password'],
                    'isguru' => $item['isguru'],
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
