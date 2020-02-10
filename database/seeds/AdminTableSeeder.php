<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
    	DB::table('admins')->insert([
    		[
		        'name' => 'Admin',
		        'email' => 'admin@rentcowork.com',
		        'password' => \Hash::make('123456'),
		        'picture' =>"http://adminview.streamhash.com/placeholder.png",
		        'created_at' => date('Y-m-d H:i:s'),
		        'updated_at' => date('Y-m-d H:i:s')
		    ],
            [
                'name' => 'Test',
                'email' => 'test@rentcowork.com',
                'password' => \Hash::make('123456'),
                'picture' =>"http://adminview.streamhash.com/placeholder.png",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
		]);
    }
}
