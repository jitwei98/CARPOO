<?

function connect_db() {
		$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=tonykjk");
		return $db;
}

?>