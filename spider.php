<html>
<head>
</head>
<body>
<?
include_once("simple_html_dom.php");
function url_exists($url)
{
    $headers = @get_headers($url);
    // print_r($headers);
    if (is_array($headers))
    {
        if(!strpos($headers[0], '200'))
            return false;
        else
            return true;    
    }         
    else
        return false;
}
$conn=new mysqli("localhost","root","meetsid20","Search_Engine");
$result=$conn->query("select * from Crawler_Seeds");
$q=array();
$visited=array();
while($yaH=$result->fetch_assoc())
{
	array_push($q,$yaH["URL"]);
	array_push($visited,$yaH["URL"]);
	echo $yaH["URL"]."<br>";
}
$count=0;
while(count($q)>0)
{
	$URL=$q[count($q)-1];
	array_pop($q);
	$html = new simple_html_dom();
	if(url_exists($URL)==true)	
		$html=file_get_html($URL);
	else
		continue;
	echo $URL."success<br>";
	if($html!=null && isset($html) && is_object($html) && !empty($html) && isset($html->nodes))
	{
		echo $html->plaintext;
		$links=$html->find("a");
	}
	else
	{
		echo "yaH<br>";
		continue;
	}
	if($links)
	{
		foreach($links as $link)
		{
			$new=$link->href;
			if($new!=null&&strlen($new)>1)
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
}
?>
</body>
</html>