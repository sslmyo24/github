if (type == main) => include main.php 
			      => if (member()) new Main
			         else {
			         	new Rep
			         	list = fetchAll repositories list
			         }
if (type == member) => new Member

rep_url : id/projectname/

public static function get_param () {
	$get_param = isset($_GET['param']) ? explode("/", $_GET['param']) : null;
	$param['type'] = isset($get_param[0]) && strlen($get_param[0]) ? $get_param[0] : "main";
	$param['rep_url'] = isset($_GET['rep_url']);
	$param['is_member'] = isset($_SESSION['member']);
	$param['member'] = $param['is_member'] ? $_SESSION['member'] : null;
	return (Object)$param;
}
