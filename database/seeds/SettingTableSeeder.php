<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

    	DB::table('settings')->insert([
    		[
		        'key' => 'site_name',
		        'value' => 'Rent Cowork'
		    ],
		    [
		        'key' => 'tag_name',
		        'value' => 'Rent Cowork'
		    ],
		    [
		        'key' => 'site_logo',
		        'value' => envfile('APP_URL').'/logo.png'
		    ],
		    [
		        'key' => 'site_icon',
		        'value' => envfile('APP_URL').'/favicon.png'
		    ],
			[
		        'key' => 'frontend_url',
		        'value' => 'http://rentcowork.rentcubo.info/'
		    ],
		    [
		        'key' => 'version',
		        'value' => 'v1.0.0'
		    ],
		    [
		        'key' => 'default_lang',
		        'value' => 'en'
		    ],
		    [
		        'key' => 'currency',
		        'value' => '$'
		    ],
		    [
		        'key' => 'currency_code',
		        'value' => 'usd'
		    ],
		    [
		        'key' => 'tax_percentage',
		        'value' => 10
		    ],
		    [
		    	'key' => 'admin_take_count',
		    	'value' => 12,
		    ],
		    [
	            'key' => 'is_demo_control_enabled', // For demo purpose
			    'value' => 0       	
			],
			[
	            'key' => "is_account_email_verification", // used to restrict the email verification process
	            'value' => 1,
	        ],
	        [
	            'key' => "is_email_notification", // used restrict the send email 
	            'value' => 1,
	        ],
	        [
	            'key' => "is_email_configured", // used check the email configuration 
	            'value' => 1,
	        ],
	        [
	            'key' => "is_push_notification",
	            'value' => 1,
	        ],
		    [
		        'key' => 'installation_steps',
		        'value' => 0
		    ],

		    [
		        'key' => 'chat_socket_url',
		        'value' => ""
		    ],
        	[
		        'key' => 'google_api_key',
		        'value' => "AIzaSyARW_YBJ-OU_RfSlMLlvLBHJaG-W_EQv4I"
		    ],
		    [
		        'key' => 'MAILGUN_PUBLIC_KEY',
		        'value' => ""
		    ],
		    [
		        'key' => 'MAILGUN_PRIVATE_KEY',
		        'value' => ""
		    ],
		    [
		    	'key' => 'stripe_publishable_key' ,
		    	'value' => "pk_test_uDYrTXzzAuGRwDYtu7dkhaF3",
		    ],
		    [
		    	'key' => 'stripe_secret_key' ,
		    	'value' => "sk_test_lRUbYflDyRP3L2UbnsehTUHW",
		    ],
		    [
		    	'key' => 'stripe_mode' ,
		    	'value' => "sandbox",
		    ],		    
        	[
        		'key' => 'token_expiry_hour',
        		'value' => 10,
        	],
        	[
	            'key' => "copyright_content",
	            'value' => "Copyrights Date('Y-m-d') . All rights reserved.",
        	],
        	[
	            'key' => "contact_email",
	            'value' => "",
        	],
        	[
	            'key' => "contact_address",
	            'value' => "",
        	],
        	[
	            'key' => "contact_mobile",
	            'value' => "",
        	],
        	[
		        'key' => 'google_analytics',
		        'value' => ""
		    ],
        	[
		        'key' => 'header_scripts',
		        'value' => ""
		    ],
		    [
		        'key' => 'body_scripts',
		        'value' => ""
		    ],
		    
        	[
	            'key' => "appstore_user",
	            'value' => "",
        	],
        	[
	            'key' => "playstore_user",
	            'value' => "",
        	],

        	[
	            'key' => "appstore_provider",
	            'value' => "",
        	],
        	[
	            'key' => "playstore_provider",
	            'value' => "",
        	],
		    [
	            'key' => "facebook_link",
	            'value' => '',
        	],
        	[
	            'key' => "linkedin_link",
	            'value' => '',
        	],
        	[
	            'key' => "twitter_link",
	            'value' => '',
        	],
        	[
	            'key' => "google_plus_link",
	            'value' => '',
        	],
        	[
	            'key' => "pinterest_link",
	            'value' => '',
        	],

		    [
		        'key' => 'demo_admin_email',
		        'value' => 'admin@rentcowork.com'
		    ],

		    [
		        'key' => 'demo_admin_password',
		        'value' => 123456
		    ],
		    [
		        'key' => 'demo_user_email',
		        'value' => 'user@rentcowork.com'
		    ],
		    [
		        'key' => 'demo_user_password',
		        'value' => 123456
		    ],
		    [
		        'key' => 'demo_provider_email',
		        'value' => 'user@rentcowork.com'
		    ],
		    [
		        'key' => 'demo_provider_password',
		        'value' => 123456
		    ],
		    [
		    	'key' =>'per_base_price',
		    	'value' => 1
		    ],
		    [
		    	'key' =>'is_appstore_updated',
		    	'value' => NO
		    ],
		    [
		        'key' => 'user_fcm_sender_id',
		        'value' => '865212328189'
		    ],
		    [
		        'key' => 'user_fcm_server_key',
		        'value' => 'AAAASJFloB0:APA91bHBe54g5RP63U3EMTRClOVIXV3R8dwQ0xdwGTimGIWuKklipnpn3a7ASHDmEIuZ_OHTUDpWPYIzsXLTXXPE_UEJOz0BR1GgZ7s_gF41DKZjmJVsO3qfUOpZT2SqVMInOcL1Z55e'
		    ],
		    [
		        'key' => 'provider_fcm_sender_id',
		        'value' => '652769449242'
		    ],
		    [
		        'key' => 'provider_fcm_server_key',
		        'value' => 'AAAAl_wXVRo:APA91bF2ns02jAWbkSMX7GndZw5noBZpKQhvTqYVZHAYQRuE0VV3nf7LdpA1cgyIopEMwa69S9stHL4Q9_iIrp-txSQs8fooAoOvl4kYQomsNfe6XBzFKQf64LDMBc9kU1EZNaEUb5hc'
		    ],
		    [
		    	'key' => 'admin_commission',
		    	'value' => ''
		    ],
		    [
		    	'key' => 'provider_commission',
		    	'value' => ''
		    ]
			

		]);
    }
}
