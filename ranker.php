<?
require_once("content-compare.php");
require_once("stemmer.php");
function ranker($query,$DocList)
{
	$query_stem=get_stem_words($query);
	$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
	$rankList=array();
	foreach($DocList as $DocID)
	{
		$result=$conn->query("select * from Documents where DocID=$DocID");
		$document=$result->fetch_assoc();
		$rankList[$document["DocID"]]=document_similarity($query_stem,json_decode($document["ContentStem"],true))+(3*document_similarity($query_stem,json_decode($document["TitleStem"],true)));
	}
	$conn->close();
	arsort($rankList);
	return  $rankList;
}
?>