<?php 
/* ######## FlappyBird API ##########
 *
 * Created by: NGenchev
 * Date: 01 Dec 2017 | Time: 08:48:23pм
 * Last update: 15.12.2017 | Time: 02:24:33pm
 * 
 * Just simple database for users
 * of most played game ever "FlappyBird"
 *
 * ######## FlappyBird API ########## 
 */

/* 	########## HOW TO USE? ###########
 *
 *	So we have Object from class FlappyBird
 *	and try to put Action with some params and/or options..
 *	   ===>  API LINK: http://domain.com/index.php?a=aaaa&p=pppp&o=oooo <===
 *	
 *	regEx:
 *	 >>> http://domain.com/index.php?a=(index|insert|update|delete)&p=(id|params)&o=(options)
 *                                                           		  =====>> options are JSON encoded <<=====
 *
 *	Index (show all) 		=> index.php?a=index 
 *		  (One By ID)		=> index.php?a=index&p=<ID>
 *  
 *  IndexBy
 *		  (sort & arrange)	=> index.php?a=indexBy&p=<option>&o=<asc|desc>
 * 
 *  Insert (new user)  		=> index.php?a=insert&p={"name":"<name>", "pwd":"<password>", "email":"<email>"}
 * 
 *  Update (by id)			=> index.php?a=update&p=<id>&o={<n1>:<o1>, <n2>:<o2>, ... <ni>:<oi>}
 *  
 *  Delete (by id) 			=> index.php?a=delete&p=<id>
 *
 * 	########## HOW TO USE? ############
 */

ob_start();

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS");
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Powered-By: Express');
header("Access-Control-Max-Age: 3600");

include "FlappyBird.php";

$act	= (string)$_GET['a']; //action
$param	= (string)$_GET['p']; //parameters
$opt	= (string)$_GET['o']; //options
$json 	= null;

$obj = new FlappyBird();
if(method_exists("FlappyBird", $act))
	$json = $obj->$act($param, $opt); // param(id|param), opt(lives,hscore);
else
	$json = $obj->index($param);
ob_clean();

echo($json);
die(exit);
