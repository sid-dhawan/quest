<?
//Crawls webpages starting with a list of seed URLs 
//Stores the fetched documents into the Documents database allotting each document a unique ID.
ini_set("max_execution_time",'300');
require_once("content-compare.php");
require_once("simple_html_dom.php");
require_once("stemmer.php");
function is_similar($page1)
{
	$conn=new mysqli("localhost","root","meetsid20","Search_Engine");
	$result=$conn->query("select * from Documents");
	while($page=$result->fetch_assoc())
	{
		if(document_similarity($page1,json_decode($page["ContentStem"],true))>=0.9)
		{
			$conn->close();
			return true;
		}
	}
	$conn->close();
	return false;
}
function url_exists($url)
{
    $headers = @get_headers($url);
    if (is_array($headers))
    {
    	$flag1=$flag2=false;
    	foreach($headers as $x)
    	{
    		if(strpos($x,"html")!=false)
    		{
    			$flag1=true;
    			break;
    		}
    		if(strpos($x,"200 OK")!=false)
    		{
    			$flag2=true;
    		}
    	}
        return $flag1 && $flag2;    
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
$count=0;
while(count($q)>0)
{
	if($count>=20)
		break;
	$URL=$q[count($q)-1];
	array_pop($q);
	$html = new simple_html_dom();
	if(url_exists($URL)==true)	
		$html=file_get_html($URL);
	else
		continue;
	$title=$html->find("title",0)->innertext;
	$content=$html->plaintext;
	$content_stem=get_stem_words($content);
	$title_stem=get_stem_words($title);
	if(is_similar($content_stem)||$content=="")
		continue;
	$count++;
	$stem_content_json=json_encode($content_stem);
	$stem_title_json=json_encode($title_stem);
	$conn->query("insert into Documents values(null,'$URL','$title','$content','$stem_title_json','$stem_content_json')");
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
				if(strpos($new,"?")!=false)//Unclean URL elimination
				{
					$new=substr($new,0,strpos($new,"?"));
				}
				if(strpos($new,"http")===false)
					continue;
				if(!isset($visited[$new]))
				{
					$visited[$new]=$visited[$URL]+1;
					array_unshift($q, $new);
				}
			}
		}
	}
}
$conn->close();
?>