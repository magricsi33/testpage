<?php return [
    'plugin' => [
        'name' => 'LSSubs',
        'description' => '',
        'subscribers' => [
            'name' => 'Feliratkozók',
        ],
        'themes' => [
            'name' => 'Témák',
        ],
        'settings' => [
            'label' => [
                'blogposts' => 'Használandó blog bejegyzés',
                'textform' => 'Használandó szöveg',
                'gdpr' => 'GDPR szabályozás szerinti Adatkezelés elfogadására vonatkozó szöveg',
            ],
            'aszf_info' => 'Bővebb tájékoztató az adatkezelésről:',
            'aszf_desc' => 'Az ön választása szerint eldöntheti hogy egy blogcikkre hivakozik, vagy itt megfogalmazza a megjelenítetndő szöveget. Az itt megadott tartalom igény szerint jeleníthető meg',
        ],
    ],
    'subscriber' => [
        'label' => [
            'name' => 'Név',
            'email' => 'E-Mail cím',
            'themes' => 'Témák',
        ],
        'list' => [
            'id' => 'Azonosító',
            'name' => 'Név',
            'email' => 'E-Mail',
            'subdate' => 'Feliratkozás Időpontja',
        ],
        'method' => [
            'export_subs' => 'Exportálás',
        ],
    ],
    'theme' => [
        'label' => [
            'name' => 'Téma neve',
        ],
        'list' => [
            'name' => 'Név',
            'id' => 'Azonosító',
        ],
    ],
    'component' => [
        'name' => 'Feliratkozó form',
        'description' => 'Kimutat egy feliratkozói formot a beállítások alapján',
        'options' => [
            'gdprType' => [
                'title' => 'Adatkezelés típusa',
                'description' => 'Az adatkezelés típusát lehet kiválasztani',
                'values' => [
                    'blog' => 'Blog bejegyzés',
                    'text' => 'Szöveg',
                ],
            ],
            'aszfPage' => [
                'title' => 'Aszf oldal',
                'description' => 'Az oldal ahol az ASZF helyezkedik el.',
            ],
            'themeType' => [
                'title' => 'Feliratkozói téma',
                'description' => 'Specifikus feliratkozói téma használata, vagy választható legyen',
                'values' => [
                    'default' => 'Mind',
                ],
            ],
            'infoTheme' => [
                'title' => 'Téma választó szöveg',
                'default' => 'Az alábbi témára szeretnék feliratkozni:',
            ],
            'infoMore' => [
                'title' => 'Link szöveg',
                'default' => 'Több információ',
            ],
            'infoButton' => [
                'title' => 'Gomb szöveg',
                'default' => 'Elküld',
            ],
        ],
        'groups' => [
            'texts' => [
                'name' => 'Szövegek',
            ],
        ],
    ],
];