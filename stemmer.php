<?
require_once("stop-list.php");
require_once("porter.php");
function strip($a)
{
	$a=preg_replace('/[^a-z0-9 \-_]+/','',strtolower($a));
	$a=preg_replace('/[\-_]+/',' ',$a);
	$a=preg_replace('/ +/',' ',$a);
	$a=preg_replace('/nbsp/','',$a);
	return $a;
}
function get_stem_words($a)
{
	$a=strip($a);
	$stemmer=new Porter();
	$list=$stemmer->stem_list(split("[ ,;\n\r\t]+", trim($a)));
	$freq=array();
	$stop_list=get_stop_list();
	foreach($list as $word)
	{
		if(isset($stop_list[$word])||strlen($word)<2)
			continue;
		if(isset($freq[$word]))
			$freq[utf8_encode($word)]++;
		else
			$freq[utf8_encode($word)]=1;
	}
	return $freq;
}?>