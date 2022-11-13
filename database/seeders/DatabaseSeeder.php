<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\RolesHasItem;
use App\Models\RolesItem;
use App\Models\Umum;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $this->call([
                ProvinsiSeeder::class,
                KotaSeeder::class,
                KecamatanSeeder::class,
            ]);

            // create Roles
            $rolesArr = ['Guru', 'Siswa'];
            foreach($rolesArr as $rolesArr){
                Roles::create([
                    'nama' => $rolesArr,
                ]);
            }

            $rolesGuru = Roles::where('nama','guru')->first()->id;
            $rolesSiswa= Roles::where('nama','siswa')->first()->id;

            $items = ['umum', 'roles', 'rolesitem', 'users'];
            foreach ($items as $item) {
                $rolesitem = RolesItem::create([
                    'nama'  => $item,
                ]);
            }

            $this->call(UserSeeder::class);

            // Roles item pivot
            $getItem = RolesItem::get();
            foreach ($getItem as $rolesitem) {
                RolesHasItem::create([
                    'roles_id'  => $rolesGuru,
                    'roles_item_id' => $rolesitem->id,
                    'create'    => 1,
                    'read'      => 1,
                    'update'    => 1,
                    'delete'    => 1,
                    'print'     => 1,
                ]);

                RolesHasItem::create([
                    'roles_id'  => $rolesSiswa,
                    'roles_item_id' => $rolesitem->id,
                    'create'    => 0,
                    'read'      => 0,
                    'update'    => 0,
                    'delete'    => 0,
                    'print'     => 0,
                ]);
            }

            $user = User::all();
            foreach($user as $u){
                DB::table('roles_user')->insert([
                    'user_id'   => $u->id,
                    'roles_id'  => ($u->isguru) ? $rolesGuru : $rolesSiswa,
                ]);
            }

            // default pengatura
            Umum::create([
                'sekolah'   => 'SDIT Al-Amanah',
                'email'     => 'emailsekolah@gmail.com',
                'website'   => 'www.demosekolah.com',
                'logo'      => 'logo.png',
                'favicon'   => 'favicon.ico',
                'telpon'    => '',
                'latitude'  => '',
                'longitude' => '',
                'meta_deskripsi'    => 'Teknologi Penghafal Al Qur\'an',
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
