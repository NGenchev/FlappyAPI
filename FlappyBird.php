<?php
require_once("DBConnection.php");
class FlappyBird
{
	protected $dbh;
	
	function __construct()
	{
		$this->dbh = (new DBConnection)->pdo_conn();
	}
	
	public function index($id = null)
	{
		$SQL = "SELECT * FROM users ";
		$SQL .=	"LEFT JOIN user_options ON users.user_id = user_options.user_id";
		$SQL .= $id != null && $id > 0 ? " WHERE users.user_id = '$id'" : ""; //if isset id check it.
		$SQL .= " ORDER BY users.user_id ASC";

		$search = $this->dbh->prepare($SQL);
		$search->execute();
		
		if($search->rowCount()):
			if($count == 1)
				$records = $search->fetch();
			else
				$records = $search->fetchAll();
			return json_encode($records, JSON_PRETTY_PRINT);
		else:
			$msg = array(
				"error" => $search->rowCount()
			);
		
			return json_encode($msg, JSON_PRETTY_PRINT);
		endif;
	}

	public function indexBy($option = "highscore", $order = "DESC") // sort by: highscore, lives, coins
	{
		$options = array(
			"highscore",
			"lives",
			"coins"
		); // order by ...

		if(!in_array($option, $options))
			$option = "highscore";
		if(!in_array(strtoupper($order), array("DESC", "ASC"))) 
			$order = "DESC";

		$SQL = "SELECT * FROM users ";
		$SQL .=	"LEFT JOIN user_options ON users.user_id = user_options.user_id ";
		$SQL .= "ORDER BY user_options.option_".$option." ".$order;

		$sort = $this->dbh->prepare($SQL);
		$sort->execute();
		
		if($sort->rowCount()):
			if($count == 1)
				$records = $sort->fetch();
			else
				$records = $sort->fetchAll();
			return json_encode($records, JSON_PRETTY_PRINT);
		else:
			$msg = array(
				"error" => $sort->rowCount()
			);
		
			return json_encode($msg, JSON_PRETTY_PRINT);
		endif;
	}
	
	public function insert($params)
	{
		$params = json_decode($params);
		$params = (array)$params; // {"name":"x", "pwd":"y", email":"name@domain"}
		
		$tableCols 		= "(";
		$tableColVals 	= "(";
		
		foreach($params as $name=>$param) // name, pwd, email
		{
			$tableCols 		.= '`user_'. $name .'`, ';
			$tableColVals 	.= "'". $param ."', ";
		}
		
		$tableCols 		= substr($tableCols, 0, strlen($tableCols)-2);
		$tableColVals 	= substr($tableColVals, 0, strlen($tableColVals)-2);
		
		$tableCols		.= ")";
		$tableColVals	.= ")";
		
		$SQL  = "INSERT INTO `users` ";
		$SQL .= $tableCols." VALUES ".$tableColVals;
		
		$insert = $this->dbh->prepare($SQL);
		$insert->execute();

		$userID = $this->dbh->lastInsertId(); 

		$SQL  = "INSERT INTO `user_options`";
		$SQL .= "(`user_id`) VALUES (?)";
		
		$createOptions = $this->dbh->prepare($SQL);
		$createOptions->bindParam(1, $userID, PDO::PARAM_INT);

		$createOptions->execute();

		$msg = array(
			"error" => ($insert->rowCount() && $createOptions->rowCount())
		);
		
		return json_encode($msg, JSON_PRETTY_PRINT);
	}
	
	public function update($id, $options)
	{
		$options = json_decode($options);
		$options = (array)$options;  

		$cols = "";
		foreach($options as $name=>$param) // name, pwd, email
		{
			$cols 	.= '`option_'. $name .'` = ';
			$cols 	.= "'". $param ."', ";
		}

		$cols 		= substr($cols, 0, strlen($cols)-2);

		//separeted from user table, only user options inside
		$SQL  = "UPDATE user_options SET "; 
		
		// set new options..
		$SQL .= $cols; 

		// update by userID
		$SQL .= "WHERE user_id = '$id'";
		
		$update = $this->dbh->prepare($SQL);
		$update->execute();

		$msg = array(
			"error" => $update->rowCount()
		);
		
		return json_encode($msg, JSON_PRETTY_PRINT);
	}
	
	public function delete($id)
	{
		$SQL  = "DELETE FROM users";
		$SQL .= " WHERE user_id = '$id'";
		
		$delete = $this->dbh->prepare($SQL);
		$delete->execute();

		$SQL  = "DELETE FROM user_options";
		$SQL .= " WHERE user_id = '$id'";
		
		$deleteOptions = $this->dbh->prepare($SQL);
		$deleteOptions->execute();

		$msg = array(
			"error" => ($delete->rowCount() && $deleteOptions->rowCount())
		);
		
		return json_encode($msg, JSON_PRETTY_PRINT);
	}
}