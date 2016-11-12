<html>
<head>
</head>
<body>
<?
include_once("simple_html_dom.php");
$conn=new mysqli("localhost","root","meetsid20","Search_Engine");
$result=$conn->query("select * from Crawler_Seeds");
$q=array();
$visited=array();
while($yaH=$result->fetch_assoc())
{
	array_push($q,$yaH["URL"]);
	array_push($visited,$yaH["URL"]);
}
$count=0;
while(count($q)>0)
{
	$URL=$q[count($q)-1];
	if($URL=="")
	{
		array_pop($q);
		continue;
	}
	$count++;
	if($count>20)
		break;
	array_pop($q);
	$html = new simple_html_dom();
	echo $html->plaintext."<br><br>";
	foreach($html->find("a") as $link)
	{
		$new=$link->href;
		if(strlen($new)>1)
		{
			if($new[0]=='/')
				$new=$URL.$new;
			if(array_search($new,$visited)==FALSE&&$new[0]!='#')
			{
				array_push($visited, $new);
				array_push($q, $new);
				echo $new."<br>";
			}
		}
	}
}
?>
</body>
</html>