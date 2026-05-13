<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // database/factories/CustomerFactory.php
    protected $model = Customer::class;

    public function definition(): array
    {
        // layanan 
        $services = [
            ['id' => 'life-style-30', 'code' => 'LS 30', 'name' => 'life style 30'],
            ['id' => 'life-crop-120', 'code' => 'LC 120', 'name' => 'life crop 120'],
            ['id' => 'life-style-200', 'code' => 'LS 200', 'name' => 'life style 200'],
            ['id' => 'life-crop-10', 'code' => 'LC 10', 'name' => 'life - crop 10'],
            ['id' => 'life-style-10', 'code' => 'LS 10', 'name' => 'life style 10'],
            ['id' => 'izzi-30', 'code' => 'IZZI 30', 'name' => 'izzi life 30 mbps'],
            ['id' => 'izzi-50', 'code' => 'IZZI 50', 'name' => 'izzi life 50 mbps'],
            ['id' => 'life-style-20', 'code' => 'LS 20', 'name' => 'life style 20'],
            ['id' => 'life-style-50', 'code' => 'LS 50', 'name' => 'life style 50'],
            ['id' => 'izzi-100', 'code' => 'IZZI 100', 'name' => 'izzi life 100 mbps'],
            ['id' => 'life-style-trusty-30', 'code' => 'LST 30', 'name' => 'life style - trusty 30'],
            ['id' => 'life-style-100', 'code' => 'LS 100', 'name' => 'life style 100'],
            ['id' => 'izzi-200', 'code' => 'IZZI 200', 'name' => 'izzi life 200 mbps'],
        ];
        
        $service = $this->faker->randomElement($services);

        return [
            'custName'        => $this->faker->name(),
            'custAddress'     => $this->faker->streetAddress(),
            'custPhone'       => '628' . $this->faker->numberBetween(100000000, 999999999),
            'custEmail'       => $this->faker->safeEmail(),
            'custGroupId'     => $this->faker->boolean(15) ? $this->faker->uuid() : null, // sering kosong
            'custProvince'    => 'Yogyakarta',
            'custDistrict'    => $this->faker->randomElement(['Sleman', 'Bantul', 'Kota Yogyakarta',]),
            'custSubDistrict' => $this->faker->randomElement(['Depok', 'Mlati', 'Umbulharjo', 'Godean', 'Cangkringan', 'Tempel']),
            'custVillage'     => $this->faker->randomElement(['Caturtunggal', 'Condongcatur', 'Baciro', 'Sidoarum', 'Gondokusuman']),
            'spCodeId'        => $service['id'],
            'spCode'          => $service['code'],
            'servicename'     => $service['name'],
            'custLatitude'    => $this->faker->boolean(10) ? $this->faker->latitude(-7.9, -7.7) : null,
            'custLongitude'   => $this->faker->boolean(10) ? $this->faker->longitude(110.3, 110.5) : null,
            'is_real_number'  => false,
            'status'          => 'active',
        ];
    }
}
