<?php
/**
 * Config for simple survey system
 */

return  [
    'domain'               => env('CONFIG_DOMAIN'),
    'ip_private'           => explode(',', env('CONFIG_IP_RANGE_PRIVATE_PC')),
    'ip_range'             => explode(',', env('CONFIG_IP_RANGE_AA_NETWORK')),
    'upload_file_path'     => env('CONFIG_UPLOAD_FILE_PATH'),
    'log_path'             => env('CONFIG_LOG_PATH'),
    'max_file_upload_size' => env('CONFIG_MAX_FILE_UPLOAD_SIZE'),
    'storage_path'         => env('STORAGE_PATH'),
];