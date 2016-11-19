<?
//Creates an inverted index of the crawed documents
//An inverted index (also referred to as postings file or inverted file) is an index data structure storing a mapping from content, such as words or numbers, to its locations (The URLs in this situation).
require_once("simple_html_dom.php");
require_once("stemmer.php");
$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
$i=1;
$result=$conn->query("select DocID, ContentStem from Documents where DocID=$i");
while($document=$result->fetch_assoc())
{
	$stem_words=json_decode($document["ContentStem"],TRUE);
	foreach($stem_words as $word=>$cnt)
	{
		$DocID=$document["DocID"];
		$conn->query("insert into `Index` values ('$word',$DocID,$cnt)");
	}
	$i++;
	$result=$conn->query("select DocID, ContentStem from Documents where DocID=$i");
}
$conn->close();
?>