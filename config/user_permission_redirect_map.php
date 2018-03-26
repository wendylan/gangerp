<?php 
	return   
	array ( 
	'redirectMap' => 
		[
	        [
	            'role'=>'次终端用户',
	            'permissions_and_router'=>[
	                [
	                    'name'=>'现货价格指数',
	                    'url'=>'/secondaryTerminal'
	                ],
	                [
	                    'name'=>'网价',
	                    'url'=>'/webprice'
	                ],
	                [
	                    'name'=>'买买买',
	                    'url'=>'/purchase'
	                ],
	                [
	                    'name'=>'资源推荐',
	                    'url'=>'/stResource'
	                ],
	                [
	                    'name'=>'订单管理',
	                    'url'=>'/salesOrder'
	                ],
	                [
	                    'name'=>'项目管理',
	                    'url'=>'/agentProject'
	                ]
	            ]

	        ],
	        [
	            'role'=>'终端用户',
	            'permissions_and_router'=>[
	                [
	                    'name'=>'现货价格指数',
	                    'url'=>'/mainprice'
	                ],
	                [
	                    'name'=>'网价',
	                    'url'=>'/webprice'
	                ],
	                [
	                    'name'=>'资源推荐',
	                    'url'=>'/stResource'
	                ],
	                [
	                    'name'=>'下单管理',
	                    'url'=>'/userdeal'
	                ],
	                [
	                    'name'=>'我的订单',
	                    'url'=>'/usercenter'
	                ],
	                [
	                    'name'=>'项目管理',
	                    'url'=>'/userprojectmanager'
	                ]
	            ]
	        ],
	    ]
    );
 ?>