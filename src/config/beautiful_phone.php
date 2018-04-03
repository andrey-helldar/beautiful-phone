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
     * Default country code.
     */

    'country_default' => 49,

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
        3022, // Russia, Chita
        812, // Russia, Saint-Petersburg
    ],

    /*
     * Template for plain text and html views.
     */

    'template' => '+%s (%s) %s',
    'template_html' => '<small>+%s (%s)</small> %s',

    /*
     * Template for link compilation.
     */

    'link' => "<a href='tel:%s'>%s</a>",
];
