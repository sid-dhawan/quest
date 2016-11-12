<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
</head>
<body>
<h1>Search Results: -</h1>
<? $a=$_GET["keyword"];

$conn = new mysqli("localhost","root","linux","search");
$sql = "SELECT Word, URL FROM search";
$result = $conn->query($sql);
$cnt=0;
while ($var=$result->fetch_assoc()) {
	if ($a==$var["Word"])
	{
		
		echo "<a href=\"".$var["URL"]."\">".$var["URL"]."</a><br>";
	}
}

?>
</body>
</html>