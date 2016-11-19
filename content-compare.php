<?
require_once("stemmer.php");
function document_similarity($freq1,$freq2)
{
	$mag1=0;
	foreach($freq1 as $word => $cnt)
		$mag1=$mag1+($cnt*$cnt);
	$mag2=0;
	foreach((array)$freq2 as $word => $cnt)
		$mag2+=$cnt*$cnt;
	$mag1=sqrt($mag1);
	$mag2=sqrt($mag2);
	$dot=0;
	foreach($freq1 as $word => $cnt)
	{
		if(isset($freq2[$word]))
			$dot+=$cnt*$freq2[$word];
	}
	if($mag1!=0&&$mag2!=0)
		return ($dot*1.0)/($mag1*$mag2);
	else
		return false;
}
function proximity()
function 
?>