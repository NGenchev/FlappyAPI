# FlappyAPI
FlappyDragon Game [PHP PDO/JSON API]

/* ######## FlappyBird API ##########
 *
 * Created by: NGenchev
 * Date: 01 Dec 2017 | Time: 08:48:23pм
 * Last update: 15.12.2017 | Time: 02:24:33pm
 * 
 * Just simple database for users
 * of the most played game ever "FlappyBird"
 *
 * ######## FlappyBird API ########## 
 */

/* 	########## HOW TO USE? ###########
 *
 *	So we have Object from class FlappyBird
 *	and try to put Action with some params and/or options..
 *	   ===>  API LINK: http://domain.com/index.php?a=<someAction>&p=<someParams>&o=<someOptions> <===
 *	
 *	regEx:
 *	 >>> http://domain.com/index.php?a=(index|insert|update|delete)&p=(id|params)&o=(options)
 *                                                           		  =====>> options are JSON encoded <<=====
 *
 *	Index (show all) 		=> index.php?a=index 
 *		  (One By ID)		=> index.php?a=index&p=<ID>
 *  
 *  IndexBy
 *		  (sort & arrange)	=> index.php?a=indexBy&p=<hightscore|lives|coins>&o=<asc|desc>
 * 
 *  Insert (new user)  		=> index.php?a=insert&p={"name":"<name>", "pwd":"<password>", "email":"<email>"}
 * 
 *  Update (by id)			=> index.php?a=update&p=<id>&o={<n1>:<o1>, <n2>:<o2>, ... <ni>:<oi>}
 *  
 *  Delete (by id) 			=> index.php?a=delete&p=<id>
 *
 * 	########## HOW TO USE? ############
 */
