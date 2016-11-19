<?
require_once("porter.php");
require_once("ranker.php");
$stemmer=new Porter();
$list=$stemmer->stem_list(split("[ ,;\n\r\t]+", trim(strtolower($_GET["keyword"]))));
$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
$sql = "SELECT DocID FROM `Index`  WHERE 0 ";
foreach($list as $x)
{
	if(!empty($x))
		$sql.="or Word='$x'";
}
$relevant=array();
$result=$conn->query($sql);
while($document=$result->fetch_assoc())
{
	array_push($relevant,$document["DocID"]);
}
$relevant=ranker($_GET["keyword"],$relevant);?>
<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"">
	<meta name="viewport" content="width = device-width, initial-scale = 1">
	<title>Search Results</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
	#top{
		position:fixed;
		bottom:0;
		right:10px;
	}
	.jumbotron a{
		font-family: "Comic Sans MS";
		font-size: 150%;
		color: blue;
	}
	.jumbotron #link{
		font-family:Tahoma, Geneva, sans-serif;
		color: green;
		font-size: 100%;
	}
	
	</style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
<div class="page-header">
<center>
	<form class="form-inline" action="Query.php">
	<img src="logoquest.png" style="width:20%;min-width:200px;">
	<div class="form-group">
      <input type="text" class="form-control" name="keyword" placeholder="Search item" value=<?echo "'".$_GET['keyword']."'";?>>
    </div>
	<button type="submit" class="btn btn-primary">Search</button>
	</form>
</center>
</div>
<div>
<?
$cnt=count($relevant);
echo "($cnt results)"?>
</div>
<br>
<?foreach($relevant as $DocID=>$relevance)
{
	$result=$conn->query("select * from Documents where DocID=$DocID");
	$document=$result->fetch_assoc();
	$URL=$document["URL"];
	$title=$document["Title"];
	$content=array();
	$content=split("[ ,;\n\r\t]+", trim($document["Content"]));
	$tokenList=split("[ ,;\n\r\t]+", trim($_GET["keyword"]));
	$matches=array();
	foreach($tokenList as $token)
	{
		for($i=0;$i<count($content);$i++)
		{
			if($stemmer->stem(strip($token))==$stemmer->stem(strip($content[$i])))
			{
				$content[$i]="<b>".$content[$i]."</b>";
				array_push($matches,$i);
				break;
			}
		}
	}
	echo "<div class='jumbotron'>";
	echo "<a href='$URL'>$title</a><div id='link'>$URL</div>";
	$display="";
	foreach($matches as $x)
	{
		for($i=max(0,$x-10);$i<min($x+20,count($content));$i++)
		{
			$display.=$content[$i]." ";
		}
		$display.="...";
	}

	echo "<div>$display</div></div>";
}
$conn->close();
?>
</div>
</div>
</div>
<a href="#top" id="top" class="btn btn-primary" role="button">Back to Top</a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
