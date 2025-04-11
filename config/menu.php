<?php
return [
    'superadmin' => [
        'Dashboard' => [
            'title' => 'menus.Dashboard',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'admin.dashboard.admindashboard',
            'route' => [
                'admindashboard'
            ],
            'link' => 'admin.dashboard.admindashboard',
            'submenu' => []
        ],
       'Quarters' => [
            'title' => 'menus.Quarters',
            'icon' => 'icon-home',
            'permission_route' => 'quarters',
            'route' => [
                'quarters',
                'quarterlistnormal',
                'quarterlistpriority',
                'quarterlistnew'
            ],
            'link' => 'quarters',
            'submenu' => [
					'Request List (Normal)' => [
                    'title' => 'menus.Request List (Normal)',
                    'icon' => 'fa fa-list',
                    'permission_route' => 'quarter.list.normal',
                    'route' => [
                        'quarterlistnormal'
                    ],
                    'link' => 'quarter.list.normal',
                ],
					'Request List (Priority)' => [
                    'title' => 'menus.Request List (Priority)',
                    'icon' => 'fa fa-list',
                    'permission_route' => 'quarterlistpriority*',
                    'route' => [
                        'quarterlistpriority'
                    ],
                    'link' => 'quarterlistpriority.index',
                ],
				/*	'New Request' => [
                    'title' => 'menus.New Request',
                    'icon' => 'fa fa-paper-plane',
                    'permission_route' => 'quarter.list.new',
                    'route' => [
                        'quarterlistnew'
                    ],
                    'link' => 'quarter.list.new',
                ],*/
			]
        ],
		 'Reports' => [
            'title' => 'menus.Reports',
            'icon' => 'icon-home',
            'permission_route' => 'reports',
            'route' => [
                'reports',
                'waitinglist',
                'allotmentlist',
                'vacantlist',
                'quarter-occupancy',
                'quarter-police-document'
            ],
            'link' => '#',
            'submenu' => [
				'Waiting List' => [
                    'title' => 'menus.Waiting List',
                    'icon' => 'fa fa-spinner',
                    'permission_route' => 'waiting.list',
                    'route' => [
                        'waitinglist'
                    ],
                    'link' => 'waiting.list',
                ],
				'Quarter Allotment' => [
                    'title' => 'menus.Quarter Allotment ',
                    'icon' => 'fa fa-thumbs-up',
                    'permission_route' => 'allotment.list',
                    'route' => [
                        'allotmentlist'
                    ],
                    'link' => 'allotment.list',
                ],
					'Vacant Quarter List' => [
                    'title' => 'menus.Vacant Quarter List',
                    'icon' => 'fa fa-users ',
                    'permission_route' => 'vacant.list',
                    'route' => [
                        'vacantlist'
                    ],
                    'link' => 'vacant.list',
                ],
                'Quarter Occupancy' => [
                    'title' => 'menus.Quarter Occupancy',
                    'icon' => 'fa fa-bars',
                    'permission_route' => 'quarter.occupancy',
                    'route' => [
                        'quarter-occupancy'
                    ],
                    'link' => 'quarter.occupancy',
                ],
                'Police Staff' => [
                    'title' => 'menus.Police Staff',
                    'icon' => 'fa fa-bars',
                    'permission_route' => 'Police.Staff.document',
                    'route' => [
                        'quarter-police-document'
                    ],
                    'link' => 'quarter.police.document',
                ],

			]
        ],
		 'User' => [
            'title' => 'menus.User',
            'icon' => 'icon-home',
            'permission_route' => 'User',
            'route' => [
                'user'
            ],
            'link' => 'user',
            'submenu' => []
        ],
         'Important link' => [
            'title' => 'menus.Important link',
            'icon' => 'nav-icon fas fa-link ',
            'permission_route' => 'masterquartertype*',
            'route' => [
                'masterquartertype',
                'masterarea',
                'addNewArea',
                'editArea/',
                'editArea/*',
                'editQuarterType/*',
                'quartertypeadministration'
            ],
            'link' => '#',
            'submenu' => [
                'Quarter Type' => [
                    'title' => 'menus.Quarter Type',
                    'icon' => 'fa fa-home',
                    'permission_route' => 'masterquartertype*',
                    'route' => [
                        'masterquartertype',
                        'editQuarterType/*'
                    ],
                    'link' => 'masterquartertype.index',
                ],
                'Area' => [
                    'title' => 'menus.Area',
                    'icon' => 'fa fa-table ',
                    'permission_route' => 'masterarea*',
                    'route' => [
                        'masterarea',
                        'addNewArea',
                        'editArea/',
                        'editArea/*',
                    ],
                    'link' => 'masterarea.index',
                ],
                // 'Quarter Type Administration' => [
                //     'title' => 'menus.quartertypeadministration',
                //     'icon' => 'fa fa-building',
                //     'permission_route' => 'quartertypeadministration*',
                //     'route' => [
                //         'quartertypeadministration'
                //     ],
                //     'link' => 'quartertypeadministration.index',
                // ],
                // 'Quarter Add' => [
                //     'title' => 'menus.quartertypeadministration',
                //     'icon' => 'fa fa-building',
                //     'permission_route' => 'quartertypeadministration*',
                //     'route' => [
                //         'quartertypeadministration'
                //     ],
                //     'link' => 'quartertypeadministration.index',
                // ],


            ]
        ],
        'DDO'=>[
            'title'=>'DDO List',
            'icon'=>'fa fa-user',
            'permission_route' => 'ddo.list',
            'route' => [
                'ddo.list'
            ],
            'link' => 'ddo.list',
          /*  'submenu' => ['Add' => [
                    'title' => 'Add New DDO',
                    'icon' => 'fa fa-building',
                    'permission_route' => 'ddo.addNew',
                    'route' => [
                        'ddo.addNew'
                    ],
                    'link' => 'ddo.addNew',
                ],]*/
        ],
        'Logout' => [
            'title' => 'menus.Logout',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'logout',
            'route' => [
                'logout'
            ],
            'link' => 'logout',
            'submenu' => []
        ],

	],
	'admin' => [

	'Dashboard' => [
            'title' => 'menus.Dashboard',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'user.dashboard.userdashboard',
            'route' => [
                'userdashboard'
            ],
            'link' => 'user.dashboard.userdashboard',
            'submenu' => []
        ],
        'Profile' => [
            'title' => 'menus.Profile',
            'icon' => 'nav-icon fa fa-user',
            'permission_route' => 'user.profile',
            'route' => [
                'profile'
            ],
            'link' => 'user.profile',
            'submenu' => []
        ],
        //16-1-2025
        'DDO Details' => [
            'title' => 'menus.DDO Details',
            'icon' => 'nav-icon fa fa-user',
            'permission_route' => 'user.ddo_details',
            'route' => [
                'ddo_details'
            ],
            'link' => 'user.ddo_details',
            'submenu' => []
        ],
        'Quarters' => [
            'title' => 'menus.Quarters',
            'icon' => 'far fa-building',
            'permission_route' => 'user.Quarters',
            'route' => [
                'user.Quarters',
                'quartersuser',
                'quartershigher',
                'quartershistory',

            ],
            'link' => 'user.Quarters',
            'submenu' => [
                'New Request' => [
                    'title' => 'menus.New Quarter',
                    'icon' => 'far fa-circle',
                    'permission_route' => 'user.Quarters',
                    'route' => [
                        'quartersuser'
                    ],
                    'link' => 'user.Quarters',
                ],
                'Higher Category Quarter Request' => [
                    'title' => 'menus.Higher Category Quarter',
                    'icon' => 'far fa-circle',
                    'permission_route' => 'user.quarter.higher',
                    'route' => [
                        'quartershigher'
                    ],
                    'link' => 'user.quarter.higher',
                ],
                'Change Quarter Request' => [
                    'title' => 'menus.quarterchangerequest',
                    'icon' => 'far fa-circle',
                    'permission_route' => 'user.quarter.change',
                    'route' => [
                        'quarterschange'
                    ],
                    'link' => 'user.quarter.change',
                ],
                'Request History' => [
                    'title' => 'menus.Request History',
                    'icon' => 'nav-icon fa fa-history',
                    'permission_route' => 'user.quarter.history',
                    'route' => [
                        'quartershistory'
                    ],
                    'link' => 'user.quarter.history',
                ],

            ]
        ],
       
        'Quarter Allotment' => [
            'title' => 'menus.Quarter Allotment ',
            'icon' => 'fa fa-thumbs-up ',
            'permission_route' => 'userallotmentlist*',
            'route' => [
                'userallotmentlist'
            ],
            'link' => 'userallotmentlist.index',
        ],
        'Logout' => [
            'title' => 'menus.Logout',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'logout',
            'route' => [
                'logout'
            ],
            'link' => 'logout',
            'submenu' => []
        ],

	],
    'ddouser' => [
        'Dashboard' => [
            'title' => 'menus.Dashboard',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'ddo.dashboard',
            'route' => [
                'ddodashboard'
            ],
            'link' => 'ddo.dashboard',
            'submenu' => []
        ],
        'Employees List' => [
            'title' => 'Employees List',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'ddo.emplist',
            'route' => [
                'emp-list'
            ],
            'link' => 'ddo.emp-list',
            'submenu' => []
        ],
       'Quarters' => [
            'title' => 'menus.Quarters',
            'icon' => 'icon-home',
            'permission_route' => 'quarters',
            'route' => [
                'ddo-quarters-normal',
                'quarterlistnormal',
                'quarterlistpriority',
                'quarterlistnew'
            ],
            'link' => 'quarters',
            'submenu' => [
					'Request List (Normal)' => [
                    'title' => 'menus.Request List (Normal)',
                    'icon' => 'fa fa-list',
                    'permission_route' => 'ddo.quarters.normal',
                    'route' => [
                        'quarterlistnormal'
                    ],
                    'link' => 'ddo.quarters.normal',
                ],
					'Request List (Priority)' => [
                    'title' => 'menus.Request List (Priority)',
                    'icon' => 'fa fa-list',
                    'permission_route' => 'quarterlistpriority*',
                    'route' => [
                        'quarterlistpriority'
                    ],
                    'link' => 'quarterlistpriority.index',
                ],
                'Rejected List' => [
                    'title' => 'menus.RejectedList',
                    'icon' => 'fa fa-list',
                    'permission_route' => 'ddo.request.rejected',
                    'route' => [
                        'ddorequestrejected'
                    ],
                    'link' => 'ddo.request.rejected',
                ],

			]
        ],
        
		 'Reports' => [
            'title' => 'menus.Reports',
            'icon' => 'icon-home',
            'permission_route' => 'reports',
            'route' => [
                'reports',
                'waitinglist',
                'allotmentlist',
                'vacantlist',
                'quarter-occupancy',
                'quarter-police-document'
            ],
            'link' => '#',
            'submenu' => [
				'Waiting List' => [
                    'title' => 'menus.Waiting List',
                    'icon' => 'fa fa-spinner',
                    'permission_route' => 'waiting.list',
                    'route' => [
                        'waitinglist'
                    ],
                    'link' => 'waiting.list',
                ],
			]
        ],

        'Logout' => [
            'title' => 'menus.Logout',
            'icon' => 'nav-icon fas fa-tachometer-alt',
            'permission_route' => 'logout',
            'route' => [
                'logout'
            ],
            'link' => 'logout',
            'submenu' => []
        ],

	],
];
