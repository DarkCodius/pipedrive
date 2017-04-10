<?php

$this->title = 'Pipedrive task';

$x = [
        [   
            'organization_name' => 'Paradise Island',
            'daughters' => [
                    [
                        'organization_name' => 'Banana tree',
                        'daughters' => [
                            ['organization_name' => 'Yellow Banana'],
                            ['organization_name' => 'Brown Banana'],
                            ['organization_name' => 'Black Banana'],
                        ],
                    ],
                    [
                        'organization_name' => 'Big Banana tree',
                        'daughters' => [
                            ['organization_name' => 'Yellow Banana'],
                            ['organization_name' => 'Brown Banana'],
                            ['organization_name' => 'Green Banana'],
                            [
                                'organization_name' => 'Black Banana',
                                'daughters' => [
                                    ['organization_name' => 'Phoneutria Spider'],
                                ]
                            ],
                        ],
                    ]
                ]
            ]
        ];
?>
<div class="site-index">
    <div class="jumbotron">
        <h2>Here is small manual</h2>
        <p class="lead">This API has 3 endpoints: </p>
        <p class="lead">1) <i><a href="/organizations">/organizations</a> - list of all organizations (GET)</i></p>
        <p class="lead">2) <i>/organizations/{name of organization} - parents,daughters,and sisters of current organization (GET)</i></p>
        <p class="lead">3) <i>/organizations - multi insert organizations (POST)</i></p>
        <p class="lead"><b>JSON string from task</b></p>
        <p class="lead"><?php echo json_encode($x); ?></p>
        <p class="lead"><b>You can use pagination</b></p>
        <p class="lead"><i>For example /organizations/{name of organization}?per-page=2&page=2</i></p>
    </div>
</div>
