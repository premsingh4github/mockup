<?php
DB::table('members')->truncate();

$members = [
            [
                
                'name' => 'prem',
                'memberType' => '1',
                'email' => 'admin@ipay.com',
                'password' => Hash::make('password'),
                'status'=> '1',
                'department'=> 'service',
            ],
            [
                
                'name' => 'prem',
                'memberType' => '1',
                'email' => 'prem@ipay.com',
                'password' => Hash::make('password'),
                'status'=> '1',
                'department'=> 'service',
            ],
        ];

        foreach($members as $member){
            Member::create($member);
        }