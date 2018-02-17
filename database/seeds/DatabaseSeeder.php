<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $faker;

	public function getFaker()
	{
		if(empty($this->faker)) {
			$this->faker = Faker\Factory::create();
		}

		return $this->faker;
	}


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    }
}
