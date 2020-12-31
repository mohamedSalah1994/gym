<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
    'font_path' => base_path('resources/fonts/'),
    'examplefont' => [
     'R'  => 'Cairo-Light.ttf',    // regular font
     'B'  => 'Cairo-Light.ttf',          // optional: bold font
     'I'  => 'Cairo-Light.ttf',    // optional: italic font
     'BI' => 'Cairo-Light.ttf',           // optional: bold-italic font
     'useOTL' => 0xFF,
     'useKashida' => 75,
]
];
