<?
require_once("stop-list.php");
function get_stem_words($a)
{
	$a=preg_replace('/[^a-zA-Z0-9\'.]+/',' ',strtolower($a));
	$a=preg_replace('/[.\']+/','',$a);
	$a=preg_replace('/ +/',' ',$a);
	$list=explode(' ',$a);
	$freq=array();
	$stop_list=get_stop_list();
	foreach($list as $word)
	{
		if($stop_list[$word])
			continue;
		if(isset($freq[$word]))
			$freq[$word]++;
		else
			$freq[$word]=1;
	}
	return $freq;
}?>