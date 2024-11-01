<?php

return [
    /*
     * DataTables JavaScript global namespace.
     */

    'namespace' => 'LaravelDataTables',

    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'table',
        'id'    => 'dataTableBuilder',
    ],

    /*
     * Html builder script template.
     */
    'script' => 'datatables::script',
    /*
         * Default condition to determine if a parameter is a callback or not.
         * Callbacks needs to start by those terms or they will be casted to string.
         */
    'callback' => ['$', '$.', 'function'],

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'datatables::editor',
];
