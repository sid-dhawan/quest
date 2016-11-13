<html>
<head>
</head>
<body>
<?
ini_set("max_execution_time",'300');
include_once("simple_html_dom.php");
$GLOBALS["documents"]=array();
function get_freq($s)
{
	$list=explode(' ',$s);
	$freq=array();
	foreach($list as $word)
	{
		if(isset($freq[$word]))
			$freq[$word]++;
		else
			$freq[$word]=1;
	}
	return $freq;
}
function document_similarity($page1,$page2)
{
	$freq1=get_freq($page1);
	$freq2=get_freq($page2);
	$mag1=0;
	foreach($freq1 as $word => $cnt)
	{
		if(empty($word))
			continue;
		$mag1=$mag1+($cnt*$cnt);
	}
	$mag2=0;
	foreach($freq2 as $word => $cnt)
	{
		if(empty($word))
			continue;
		$mag2+=$cnt*$cnt;
	}
	$mag1=sqrt($mag1);
	$mag2=sqrt($mag2);
	if($mag1*1.0/$mag2<0.8||$mag2*1.0/$mag1<0.8)
		return 0;
	$dot=0;
	foreach($freq1 as $word => $cnt)
	{
		if(empty($word))
			continue;
		if(isset($freq2[$word]))
			$dot+=$cnt*$freq2[$word];
	}
	return ($dot*1.0)/($mag1*$mag2);
}
function is_similar($page1)
{
	foreach($GLOBALS["documents"] as $page2)
	{ 
		if(document_similarity($page1,$page2)>=0.9)
			return true;
	}
	return false;
}
function url_exists($url)
{
	if(strpos($url,".pdf")!=false)
		return false;
    $headers = @get_headers($url);
    if (is_array($headers))
    {
    	$flag=false;
    	foreach($headers as $x)
    	{
    		if(strpos($x,"html")!=false)
    		{
    			$flag=true;
    			break;
    		}
    	}
        if(!strpos($headers[0], '200'))
            return false && $flag;
        else
            return true && $flag;    
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
	$visited[$yaH["URL"]]=1;
}
$q=array();
array_push($q,"https://iiitd.ac.in");
$visited=array();
$visited["https://iiitd.ac.in"]=1;
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
	if(is_similar($html->plaintext))
		continue;
	else if($html!=NULL && isset($html) && is_object($html) && !empty($html) && isset($html->nodes))
		array_push($GLOBALS["documents"],$html->plaintext);
	$count++;
	if($count>20)
		break;
	echo "Link ".$count."		Depth ".$visited[$URL]."		".$URL."<br><br>".$html->plaintext."<br><br>---------------------<br>";
	$freq=get_freq($html->plaintext);
	foreach($freq as $word=>$cnt)
	{
		if(empty($word))
			continue;
		$sql="insert into Search values(\"".$word."\",\"".$URL."\",".$cnt.")";
		$conn->query($sql);
	}
	//Indexer Code goes here
	if($html!=NULL && isset($html) && is_object($html) && !empty($html) && isset($html->nodes))
		$links=$html->find("a");
	else
		continue;
	if(!empty($links) && $visited[$URL]<3)
	{	
		foreach($links as $link)
		{
			$new=$link->href;
			if($new!=null&&strlen($new)>1)
			{
				if($new[0] == '#')
					continue;
				if(strpos($new,"//")===0)
					$new="http:".$new;
				else if($new[0]=='/')
				{
					if(strpos($URL,"/",strpos($URL,":")+3)==false)
					{
						$new=$URL.$new;
					}
					else 
						$new=substr($URL,0,strpos($URL,"/",strpos($URL,":")+3)).$new;
				}
				if(strpos($new,"?")!=false)
				{
					$new=substr($new,0,strpos($new,"?"));
				}
				if(strpos($new,"http")===false)
					continue;
				if(!isset($visited[$new]))
				{
					$visited[$new]=$visited[$URL]+1;
					array_unshift($q, $new);
					echo "-----------------------".$new."<br>";
				}
			}
		}
	}
}
$conn->close();
?>
</body>
</html>