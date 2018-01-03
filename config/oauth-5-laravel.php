<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => '',
			'client_secret' => '',
			'scope'         => [],
		],
        'Google' => [
            'client_id'     => '900382033604-p97sav00vco1g1iuj3r53b2i8210olt3.apps.googleusercontent.com',
            'client_secret' => 'XHSMxzLWE89axFYRLaTcYfSV',
            'scope'         => ['userinfo_email', 'userinfo_profile'],
        ],
    ]

];