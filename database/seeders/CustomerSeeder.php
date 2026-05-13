<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/CustomerSeeder.php

    public function run(): void
    {
        

            
            Customer::truncate();

            $total = 20000;
            $realNumbers = [
                //  nomor WA ASLI 
                '62882008775529',
            ];

            for ($i = 1; $i <= $total; $i++) {
                $custNumber = 'LM' . str_pad($i, 5, '0', STR_PAD_LEFT);

                $isReal = $i <= count($realNumbers);

                Customer::factory()->create([
                    'custNumber'     => $custNumber,
                    'custPhone' => $isReal ? $realNumbers[$i - 1] : '628' . random_int(100000000, 999999999),
                    'is_real_number' => $isReal,
                ]);
            }
    }
}

