<?
function get_stop_list()
{
	$ret=array();
	$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
	$result=$conn->query("select * from Stop_List");
	while($word=$result->fetch_assoc())
	{
		$ret[$word["StopWords"]]=true;
	}
	$conn->close();
	return $ret;
}
?>