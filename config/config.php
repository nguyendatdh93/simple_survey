<?php
/**
 * Config for simple survey system
 */

return  [
    'domain'                   => env('CONFIG_DOMAIN'),
    'ip_private'               => explode(',', env('CONFIG_IP_RANGE_PRIVATE_PC')),
    'ip_range'                 => explode(',', env('CONFIG_IP_RANGE_AA_NETWORK')),
    'upload_file_path'         => env('CONFIG_UPLOAD_FILE_PATH'),
    'log_path'                 => env('CONFIG_LOG_PATH'),
    'max_file_upload_size'     => env('CONFIG_MAX_FILE_UPLOAD_SIZE'),
    'file_types_allow'         => explode(',', strtolower(env('CONFIG_FILE_TYPES_ALLOW', 'jpeg,png,gif,bmp,svg'))),
    'storage_path'             => env('STORAGE_PATH'),
    'encrypt_private_key'      => 'dadb97fbd7e9dd6e46436fa72848217d',
	'copyright_text_in_footer' => env('COPYRIGHT_TEXT_IN_FOOTER'),
	'url_sign_out_google'      => env('URL_SIGN_OUT_GOOGLE', 'https://accounts.google.com/o/oauth2/revoke?token'),
	'key_secret_encrypt_url'   => env('KEY_SECRET_ENCRYPT_URL', 'MTVzaW1wbGVfc3VydmV5X2tleV9zY3JldGU'),
];