<?php return [
    // This contains the Laravel Packages that you want this plugin to utilize listed under their package identifiers
    'packages' => [        
        'maatwebsite/excel' => [
            'providers' => [
                '\Maatwebsite\Excel\ExcelServiceProvider::class',
            ],

            'aliases' => [
                'Excel' => '\Maatwebsite\Excel\Facades\Excel::class',
            ],

            'config_namespace' => 'excel',
            
            'config' => [
                'exports' => [

                    /*
                    |--------------------------------------------------------------------------
                    | Chunk size
                    |--------------------------------------------------------------------------
                    |
                    | When using FromQuery, the query is automatically chunked.
                    | Here you can specify how big the chunk should be.
                    |
                    */
                    'chunk_size'             => 1000,
            
                    /*
                    |--------------------------------------------------------------------------
                    | Pre-calculate formulas during export
                    |--------------------------------------------------------------------------
                    */
                    'pre_calculate_formulas' => false,
            
                    /*
                    |--------------------------------------------------------------------------
                    | CSV Settings
                    |--------------------------------------------------------------------------
                    |
                    | Configure e.g. delimiter, enclosure and line ending for CSV exports.
                    |
                    */
                    'csv'                    => [
                        'delimiter'              => ',',
                        'enclosure'              => '"',
                        'line_ending'            => PHP_EOL,
                        'use_bom'                => false,
                        'include_separator_line' => false,
                        'excel_compatibility'    => false,
                    ],
                ],
            
                'imports'            => [
            
                    'read_only' => true,
            
                    'heading_row' => [
            
                        /*
                        |--------------------------------------------------------------------------
                        | Heading Row Formatter
                        |--------------------------------------------------------------------------
                        |
                        | Configure the heading row formatter.
                        | Available options: none|slug|custom
                        |
                        */
                        'formatter' => 'slug',
                    ],
            
                    /*
                    |--------------------------------------------------------------------------
                    | CSV Settings
                    |--------------------------------------------------------------------------
                    |
                    | Configure e.g. delimiter, enclosure and line ending for CSV imports.
                    |
                    */
                    'csv'         => [
                        'delimiter'              => ',',
                        'enclosure'              => '"',
                        'escape_character'       => '\\',
                        'contiguous'             => false,
                        'input_encoding'         => 'UTF-8',
                    ],
                ],
            
                'value_binder' => [
            
                    /*
                    |--------------------------------------------------------------------------
                    | Default Value Binder
                    |--------------------------------------------------------------------------
                    |
                    | PhpSpreadsheet offers a way to hook into the process of a value being
                    | written to a cell. In there some assumptions are made on how the
                    | value should be formatted. If you want to change those defaults,
                    | you can implement your own default value binder.
                    |
                    */
                    'default' => Maatwebsite\Excel\DefaultValueBinder::class,
                ],
            
                'transactions' => [
            
                    /*
                    |--------------------------------------------------------------------------
                    | Transaction Handler
                    |--------------------------------------------------------------------------
                    |
                    | By default the import is wrapped in a transaction. This is useful
                    | for when an import may fail and you want to retry it. With the
                    | transactions, the previous import gets rolled-back.
                    |
                    | You can disable the transaction handler by setting this to null.
                    | Or you can choose a custom made transaction handler here.
                    |
                    | Supported handlers: null|db
                    |
                    */
                    'handler' => 'db',
                ],
            
                'temporary_files' => [
            
                    /*
                    |--------------------------------------------------------------------------
                    | Local Temporary Path
                    |--------------------------------------------------------------------------
                    |
                    | When exporting and importing files, we use a temporary file, before
                    | storing reading or downloading. Here you can customize that path.
                    |
                    */
                    'local_path'  => sys_get_temp_dir(),
            
                    /*
                    |--------------------------------------------------------------------------
                    | Remote Temporary Disk
                    |--------------------------------------------------------------------------
                    |
                    | When dealing with a multi server setup with queues in which you
                    | cannot rely on having a shared local temporary path, you might
                    | want to store the temporary file on a shared disk. During the
                    | queue executing, we'll retrieve the temporary file from that
                    | location instead. When left to null, it will always use
                    | the local path. This setting only has effect when using
                    | in conjunction with queued imports and exports.
                    |
                    */
                    'remote_disk' => null,
            
                ],
            ],
        ],
    ],
];
