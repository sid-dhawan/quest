<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
</head>
<body>
<h1>Search Results: -</h1>
<?
$list=explode(' ',$_GET["keyword"]);
$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
foreach($list as $a)
{
	if(empty($a))
		continue;
	$sql = "SELECT * FROM Search  WHERE Word=\"".$a."\" ORDER BY Freq DESC";
	$result = $conn->query($sql);
	while ($var=$result->fetch_assoc()) {
			echo "<a href=\"".$var["URL"]."\">".$var["Title"]."</a><br>";
	}
}

?>
</body>
</html>