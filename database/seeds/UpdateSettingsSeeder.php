<?php

use Illuminate\Database\Seeder;

class UpdateSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('settings')->insert([
    	
		    [
	            'key' => 'is_email_enabled',
			    'value' => YES
		    ],

		]);
    }
}
