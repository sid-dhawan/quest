<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
</head>
<body>
<h1>Search Results: -</h1>
<? $a=$_GET["keyword"];

$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
$sql = "SELECT * FROM Search  WHERE Word=\"".$a."\" ORDER BY Freq DESC";
$result = $conn->query($sql);
$cnt=0;
while ($var=$result->fetch_assoc()) {
		echo "<a href=\"".$var["URL"]."\">".$var["URL"]."</a><br>";
}

?>
</body>
</html>