<?php
try {


//$json_str =$_POST["JSONData"];
	$json_str = file_get_contents('php://input');
	$json_data = json_decode($json_str, true);

	//echo $json_data;
	/*$store_id = $_POST["store_id"];
	$name = $_POST["name"];
	$user_id = $_POST["user_id"];*/

	$store_id = $json_data["store_id"];
	$name = $json_data["name"];
	$user_id = $json_data["user_id"];

	//echo $json_data;

	//$login_id = json_data["login_id"];
	//$word = json_data["password"];
	// connect

	$db = new PDO("mysql:host=localhost;dbname=test;charset=utf8mb4", "root", "");

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	//$sql = "PRAGMA foreign_keys = ON";
	//$db->query($sql);

	$sql = "select store_id from stores where name = $name";
	$res = $db -> query($sql);
	$data = $res -> fetchAll();

	if (empty($data)) {

		$data = array($name, $user_id);

		$db -> beginTransaction();
		try {
				$sql = "insert into stores(name, user_id) values (
				 ?, ?)";
				$stmt = $db -> prepare($sql);
				$stmt-> execute($data);

				$db -> commit();

				// cutting
				$db = null;
				$response = "true";
				echo $response;
		} catch (Exception $e) {
				$db -> rollback();
				throw $e;
		}
	} else {
		$response =  "false";
		echo $response;
	//	echo "false";
	}

} catch (Exception $e) {

	echo $e->getMessage() . PHP_EOL;
	$response =  "false";
	echo $response;
//	echo "false";

}

?>
