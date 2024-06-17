<?php

return [
    'normal' => [
        'name'=> 'Normal',
    ],
    'express' => [
        'name'=> 'Express',
    ],
    '1' => [
        'name' => 'Wash & Iron',
        'normal' => [
            'price' => 7000,
            'minKg' => 2,
            'description' => 'Normal (Rp 7.000/kg, 2-3 days, min. 2kg)',
        ],
        'express' => [
            'price' => 10000,
            'minKg' => 2,
            'description' => 'Express (Rp 10.000/kg, 1 day, min. 2kg)',
        ],
    ],
    '2' => [
        'name' => 'Iron Only',
        'normal' => [
            'price' => 6000,
            'minKg' => 2,
            'description' => 'Normal (Rp 6.000/kg, 2-3 days, min. 2kg)',
        ],
        'express' => [
            'price' => 9000,
            'minKg' => 2,
            'description' => 'Express (Rp 9.000/kg, 1 day, min. 2kg)',
        ],
    ],
];
