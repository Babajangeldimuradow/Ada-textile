<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'description' => "ADA Dokma Toplumy — ýokary hilli, islege laýyk gelýän tekstil önümleri bilen siziň rahatlygyňyz we stile üns berýär. Ýeňil dokma, bezegli önümler we täze kolleksiýalar bilen ähli ýaşlar üçin amatly saýlawlar döredilýär.",
            'short_des' => "ADA Dokma Toplumy — ýokary hilli we islege laýyk gelýän tekstil önümleri bilen siziň rahatlygyňyza we stile üns berýär.",
            'photo' => "photos/1/logo.png",
              'logo' => "photos/1/logo1.jpg  ",
            'address' => "Biziň salgymyz: Aşgabat şäheri Parahat 4/1",
            'email' => "ADAdokmatoplum@gmail.com",
            'phone' => "+99361585023",
        ];

        // Eger bar bolsa üýtget, ýok bolsa goş
        DB::table('settings')->updateOrInsert(
            ['id' => 1], // bu ýerde 1 saýlap goýduk, diňe bir setir üçin
            $data
        );
    }
}
