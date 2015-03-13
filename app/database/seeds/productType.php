<?php
DB::table('productTypes')->truncate();

$members = [
            [
                
                'name' => 'Mockup',
                'description'=> ' '
            ],
            [
                
                'name' => 'Wireframe',
                 'description'=> ' '
            ],
            [
                
                'name' => 'Paper Design',
                 'description'=> ' '
            ],
            [
                'name' => 'HTML'
                'description' => ' '
            ]
        ];

        foreach($members as $member){
            ProductType::create($member);
        }