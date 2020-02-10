<?php

use Illuminate\Database\Seeder;

class LookupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	DB::table('lookups')->insert([
    		[
		        'type' => 'space_type',
		        'key' => 'own_space',
		        'value' => 'Own Space',
		        'status' => APPROVED,
		        'created_at' => date('Y-m-d H:i:s'),
		        'updated_at' => date('Y-m-d H:i:s')
		    ],
            [
		        'type' => 'space_type',
		        'key' => 'private_space',
		        'value' => 'Private Space',
		        'status' => APPROVED,
		        'created_at' => date('Y-m-d H:i:s'),
		        'updated_at' => date('Y-m-d H:i:s')
		    ],
		    [
		        'type' => 'space_type',
		        'key' => 'shared_space',
		        'value' => 'Shared Space',
		        'status' => APPROVED,
		        'created_at' => date('Y-m-d H:i:s'),
		        'updated_at' => date('Y-m-d H:i:s')
		    ],
		    [
		        'type' => 'space_type',
		        'key' => 'office_space',
		        'value' => 'Office Space',
		        'status' => APPROVED,
		        'created_at' => date('Y-m-d H:i:s'),
		        'updated_at' => date('Y-m-d H:i:s')
		    ],
		]);
    }
}
