<?php

return [
    'app' => [
        'id' => env('APP_ID'),
        'debug_from_request' => (bool)env('APP_DEBUG_FROM_REQUEST', false),
    ],
    'html_index' => [
        // in public folder
        'paths' => [
            //'admin',
        ],
        'files' => [
            'index.html',
            'index.htm',
        ],
    ],
    'console' => [
        'commands' => [
            'logging_except' => [
                Illuminate\Queue\Console\WorkCommand::class,
                Illuminate\Console\Scheduling\ScheduleRunCommand::class,
            ],
        ],
        'schedules' => [
            'definitions' => [
                [
                    'schedules' => [
                        //App\Console\Schedules\TrialSchedule::class,
                    ],
                    'frequencies' => [
                        'everyMinute',
                    ],
                ],
            ],
        ],
    ],
    'mail' => [
        'always_to' => [
            'address' => env('MAIL_ALWAYS_TO_ADDRESS'),
            'name' => env('MAIL_ALWAYS_TO_NAME'),
        ],
    ],
    'client' => [
        'default' => 'default',
        'settings' => [
            'default' => [
                'locale' => 'en',
                'country' => 'US',
                'timezone' => 'UTC',
                'currency' => 'USD',
                'number_format' => 'point_comma',
                'long_date_format' => 0,
                'short_date_format' => 0,
                'long_time_format' => 0,
                'short_time_format' => 0,
            ],
        ],
        'routes' => [
            //'*' => 'default',
        ],
    ],
    'supported_locales' => array_filter(explode(',', env('APP_LOCALE_SUPPORTED', 'en')), function ($locale) {
        return !empty($locale);
    }),
    'currencies' => [
        'USD' => ['symbol' => '$'],
        'VND' => ['symbol' => '₫'],
    ],
    'number_formats' => [
        'point_comma',
        'point_space',
        'comma_point',
        'comma_space',
    ],
    'countries' => [
        'AF' => ['calling_code' => '93'],
        'AX' => ['calling_code' => '358'],
        'AL' => ['calling_code' => '355'],
        'DZ' => ['calling_code' => '213'],
        'AS' => ['calling_code' => '1'],
        'AD' => ['calling_code' => '376'],
        'AO' => ['calling_code' => '244'],
        'AI' => ['calling_code' => '1'],
        'AQ' => ['calling_code' => ''],
        'AG' => ['calling_code' => '1'],
        'AR' => ['calling_code' => '54'],
        'AM' => ['calling_code' => '374'],
        'AW' => ['calling_code' => '297'],
        'AC' => ['calling_code' => '247'],
        'AU' => ['calling_code' => '61'],
        'AT' => ['calling_code' => '43'],
        'AZ' => ['calling_code' => '994'],
        'BS' => ['calling_code' => '1'],
        'BH' => ['calling_code' => '973'],
        'BD' => ['calling_code' => '880'],
        'BB' => ['calling_code' => '1'],
        'BY' => ['calling_code' => '375'],
        'BE' => ['calling_code' => '32'],
        'BZ' => ['calling_code' => '501'],
        'BJ' => ['calling_code' => '229'],
        'BM' => ['calling_code' => '1'],
        'BT' => ['calling_code' => '975'],
        'BO' => ['calling_code' => '591'],
        'BQ' => ['calling_code' => '599'],
        'BA' => ['calling_code' => '387'],
        'BW' => ['calling_code' => '267'],
        'BV' => ['calling_code' => '47'],
        'BR' => ['calling_code' => '55'],
        'IO' => ['calling_code' => '246'],
        'VG' => ['calling_code' => '1'],
        'BN' => ['calling_code' => '673'],
        'BG' => ['calling_code' => '359'],
        'BF' => ['calling_code' => '226'],
        'BI' => ['calling_code' => '257'],
        'KH' => ['calling_code' => '855'],
        'CM' => ['calling_code' => '237'],
        'CA' => ['calling_code' => '1'],
        'IC' => ['calling_code' => '34'],
        'CV' => ['calling_code' => '238'],
        'KY' => ['calling_code' => '1'],
        'CF' => ['calling_code' => '236'],
        'EA' => ['calling_code' => '34'],
        'TD' => ['calling_code' => '235'],
        'CL' => ['calling_code' => '56'],
        'CN' => ['calling_code' => '86'],
        'CX' => ['calling_code' => '61'],
        'CP' => ['calling_code' => ''],
        'CC' => ['calling_code' => '61'],
        'CO' => ['calling_code' => '57'],
        'KM' => ['calling_code' => '269'],
        'CD' => ['calling_code' => '243'],
        'CG' => ['calling_code' => '242'],
        'CK' => ['calling_code' => '682'],
        'CR' => ['calling_code' => '506'],
        'CI' => ['calling_code' => '225'],
        'HR' => ['calling_code' => '385'],
        'CU' => ['calling_code' => '53'],
        'CW' => ['calling_code' => '599'],
        'CY' => ['calling_code' => '357'],
        'CZ' => ['calling_code' => '420'],
        'DK' => ['calling_code' => '45'],
        'DG' => ['calling_code' => '246'],
        'DJ' => ['calling_code' => '253'],
        'DM' => ['calling_code' => '1'],
        'DO' => ['calling_code' => '1'],
        'EC' => ['calling_code' => '593'],
        'EG' => ['calling_code' => '20'],
        'SV' => ['calling_code' => '503'],
        'GQ' => ['calling_code' => '249'],
        'ER' => ['calling_code' => '291'],
        'EE' => ['calling_code' => '372'],
        'ET' => ['calling_code' => '251'],
        'FK' => ['calling_code' => '500'],
        'FO' => ['calling_code' => '298'],
        'FJ' => ['calling_code' => '679'],
        'FI' => ['calling_code' => '358'],
        'FR' => ['calling_code' => '33'],
        'GF' => ['calling_code' => '594'],
        'PF' => ['calling_code' => '689'],
        'TF' => ['calling_code' => '262'],
        'GA' => ['calling_code' => '241'],
        'GM' => ['calling_code' => '220'],
        'GE' => ['calling_code' => '995'],
        'DE' => ['calling_code' => '49'],
        'GH' => ['calling_code' => '233'],
        'GI' => ['calling_code' => '350'],
        'GR' => ['calling_code' => '30'],
        'GL' => ['calling_code' => '299'],
        'GD' => ['calling_code' => '1'],
        'GP' => ['calling_code' => '590'],
        'GU' => ['calling_code' => '1'],
        'GT' => ['calling_code' => '502'],
        'GG' => ['calling_code' => '44'],
        'GN' => ['calling_code' => '224'],
        'GW' => ['calling_code' => '245'],
        'GY' => ['calling_code' => '592'],
        'HT' => ['calling_code' => '509'],
        'HM' => ['calling_code' => ''],
        'HN' => ['calling_code' => '504'],
        'HK' => ['calling_code' => '852'],
        'HU' => ['calling_code' => '36'],
        'IS' => ['calling_code' => '354'],
        'IN' => ['calling_code' => '91'],
        'ID' => ['calling_code' => '62'],
        'IR' => ['calling_code' => '98'],
        'IQ' => ['calling_code' => '964'],
        'IE' => ['calling_code' => '353'],
        'IM' => ['calling_code' => '44'],
        'IL' => ['calling_code' => '972'],
        'IT' => ['calling_code' => '39'],
        'JM' => ['calling_code' => '1'],
        'JP' => ['calling_code' => '81'],
        'JE' => ['calling_code' => '44'],
        'JO' => ['calling_code' => '962'],
        'KZ' => ['calling_code' => '7'],
        'KE' => ['calling_code' => '254'],
        'KI' => ['calling_code' => '686'],
        'KP' => ['calling_code' => '850'],
        'KR' => ['calling_code' => '82'],
        'XK' => ['calling_code' => '381'],
        'KW' => ['calling_code' => '965'],
        'KG' => ['calling_code' => '996'],
        'LA' => ['calling_code' => '856'],
        'LV' => ['calling_code' => '371'],
        'LB' => ['calling_code' => '961'],
        'LS' => ['calling_code' => '266'],
        'LR' => ['calling_code' => '231'],
        'LY' => ['calling_code' => '218'],
        'LI' => ['calling_code' => '423'],
        'LT' => ['calling_code' => '370'],
        'LU' => ['calling_code' => '352'],
        'MO' => ['calling_code' => '853'],
        'MK' => ['calling_code' => '389'],
        'MG' => ['calling_code' => '261'],
        'MW' => ['calling_code' => '265'],
        'MY' => ['calling_code' => '60'],
        'MV' => ['calling_code' => '960'],
        'ML' => ['calling_code' => '223'],
        'MT' => ['calling_code' => '356'],
        'MH' => ['calling_code' => '692'],
        'MQ' => ['calling_code' => '596'],
        'MR' => ['calling_code' => '222'],
        'MU' => ['calling_code' => '230'],
        'YT' => ['calling_code' => '262'],
        'MX' => ['calling_code' => '52'],
        'FM' => ['calling_code' => '691'],
        'MD' => ['calling_code' => '373'],
        'MC' => ['calling_code' => '377'],
        'MN' => ['calling_code' => '976'],
        'ME' => ['calling_code' => '382'],
        'MS' => ['calling_code' => '1'],
        'MA' => ['calling_code' => '212'],
        'MZ' => ['calling_code' => '258'],
        'MM' => ['calling_code' => '95'],
        'NA' => ['calling_code' => '264'],
        'NR' => ['calling_code' => '674'],
        'NP' => ['calling_code' => '977'],
        'NL' => ['calling_code' => '31'],
        'NC' => ['calling_code' => '687'],
        'NZ' => ['calling_code' => '64'],
        'NI' => ['calling_code' => '505'],
        'NE' => ['calling_code' => '227'],
        'NG' => ['calling_code' => '234'],
        'NU' => ['calling_code' => '683'],
        'NF' => ['calling_code' => '672'],
        'MP' => ['calling_code' => '1'],
        'NO' => ['calling_code' => '47'],
        'OM' => ['calling_code' => '968'],
        'PK' => ['calling_code' => '92'],
        'PW' => ['calling_code' => '680'],
        'PS' => ['calling_code' => '970'],
        'PA' => ['calling_code' => '507'],
        'PG' => ['calling_code' => '675'],
        'PY' => ['calling_code' => '595'],
        'PE' => ['calling_code' => '51'],
        'PH' => ['calling_code' => '63'],
        'PN' => ['calling_code' => '64'],
        'PL' => ['calling_code' => '48'],
        'PT' => ['calling_code' => '351'],
        'PR' => ['calling_code' => '1'],
        'QA' => ['calling_code' => '974'],
        'RE' => ['calling_code' => '262'],
        'RO' => ['calling_code' => '40'],
        'RU' => ['calling_code' => '7'],
        'RW' => ['calling_code' => '250'],
        'BL' => ['calling_code' => '590'],
        'SH' => ['calling_code' => '290'],
        'KN' => ['calling_code' => '1'],
        'LC' => ['calling_code' => '1'],
        'MF' => ['calling_code' => '590'],
        'PM' => ['calling_code' => '508'],
        'VC' => ['calling_code' => '1'],
        'WS' => ['calling_code' => '685'],
        'SM' => ['calling_code' => '378'],
        'ST' => ['calling_code' => '239'],
        'SA' => ['calling_code' => '966'],
        'SN' => ['calling_code' => '221'],
        'RS' => ['calling_code' => '381'],
        'SC' => ['calling_code' => '248'],
        'SL' => ['calling_code' => '232'],
        'SG' => ['calling_code' => '65'],
        'SX' => ['calling_code' => '599'],
        'SK' => ['calling_code' => '421'],
        'SI' => ['calling_code' => '386'],
        'SB' => ['calling_code' => '677'],
        'SO' => ['calling_code' => '252'],
        'ZA' => ['calling_code' => '27'],
        'GS' => ['calling_code' => '500'],
        'SS' => ['calling_code' => '211'],
        'ES' => ['calling_code' => '34'],
        'LK' => ['calling_code' => '94'],
        'SD' => ['calling_code' => '249'],
        'SR' => ['calling_code' => '597'],
        'SJ' => ['calling_code' => '47'],
        'SZ' => ['calling_code' => '268'],
        'SE' => ['calling_code' => '46'],
        'CH' => ['calling_code' => '41'],
        'SY' => ['calling_code' => '963'],
        'TW' => ['calling_code' => '886'],
        'TJ' => ['calling_code' => '992'],
        'TZ' => ['calling_code' => '255'],
        'TH' => ['calling_code' => '66'],
        'TL' => ['calling_code' => '670'],
        'TG' => ['calling_code' => '228'],
        'TK' => ['calling_code' => '690'],
        'TO' => ['calling_code' => '676'],
        'TT' => ['calling_code' => '1'],
        'TA' => ['calling_code' => '290'],
        'TN' => ['calling_code' => '216'],
        'TR' => ['calling_code' => '90'],
        'TM' => ['calling_code' => '993'],
        'TC' => ['calling_code' => '1'],
        'TV' => ['calling_code' => '688'],
        'UG' => ['calling_code' => '256'],
        'UA' => ['calling_code' => '380'],
        'AE' => ['calling_code' => '971'],
        'GB' => ['calling_code' => '44'],
        'US' => ['calling_code' => '1'],
        'UM' => ['calling_code' => '1'],
        'VI' => ['calling_code' => '1'],
        'UY' => ['calling_code' => '598'],
        'UZ' => ['calling_code' => '998'],
        'VU' => ['calling_code' => '678'],
        'VA' => ['calling_code' => '39'],
        'VE' => ['calling_code' => '58'],
        'VN' => ['calling_code' => '84'],
        'WF' => ['calling_code' => '681'],
        'EH' => ['calling_code' => '212'],
        'YE' => ['calling_code' => '967'],
        'ZM' => ['calling_code' => '260'],
        'ZW' => ['calling_code' => '263'],
    ],
];