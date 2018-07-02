<?php

return [
    /*
     * List of country codes.
     */

    'countries' => [
        3, // Ukraine
        7, // Russia
        8, // Russia
        49, // Germany
    ],

    /*
     * Default codes.
     */

    'default_country' => 7,
    'default_city'    => 812,

    /*
     * List of city codes.
     */

    'codes' => [
        999, // Russia, Yota
        996, // Russia, Yota
        995, // Russia, Yota
        931, // Russia, Megafon
        924, // Russia, Megafon
        914, // Russia, MTS
        812, // Russia, Saint-Petersburg
    ],

    /*
     * Templates.
     */

    'template_prefix_text' => '+%s (%s) %s',
    'template_prefix_html' => '<span>+%s (%s)</span> %s',

    'template_link' => "<a href='tel:%s'>%s</a>",
];
