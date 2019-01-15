<?
require_once("bittorrent.php");
require_once ("Torrent.php");


function scrape_check($id) 
{


	@set_time_limit(0);
	@ignore_user_abort(1);

/////// start torrent class (scraping)

	$torrent = new Torrent('./torrents/'.$id.'.torrent');
	
	$ann_s		= $torrent->announce();
	$scr 		= $torrent->scrape();
	$t_hash     = $torrent->hash_info();
//	$mag        = $torrent->magnet(); ///generate magnet link
//	$fsize      = $torrent->size( 2 );


foreach($scr as $mx) 
{
if(is_array($mx) 	&& array_key_exists('complete', $mx)	|| 
is_array($mx) 		&& array_key_exists('downloaded', $mx)	||
is_array($mx) 		&& array_key_exists('incomplete', $mx)) 
{
$t_complete 	+= $mx['complete'];
$t_downloaded 	+= $mx['downloaded'];
$t_incomplete 	+= $mx['incomplete'];
}
}
$tx_cx1 = $t_complete;
$tx_dx1 = $t_downloaded;
$tx_ix1 = $t_incomplete;

if (!isset($t_hash))
{
$error_x += 1;
}
if (!isset($tx_cx1) && !isset($tx_dx1) && !isset($tx_ix1))
{
$error_x += 2;
}
if ($error_x == 2)
{
$rrra_seed = rand(1,999);
$rrra_pir  = rand(1,99);
$tx_status = 1;
$tx_cx1 = $rrra_seed;
$tx_dx1 = $rrra_seed+$rrra_seed;
$tx_ix1 = $rrra_pir;
$t_ann 	= 'Скачал? Не слазь с раздачи!';
}
else if ($error_x == 3)
{
$tx_status = 0;
$tx_cx1 = 0;
$tx_dx1 = 0;
$tx_ix1 = 0;
$t_hash = 0;
$t_name = 'File is dead!';
$t_size = 0;
$t_ann 	= 'Торрент мертв.';
}
else
{
if ($tx_cx1 > 0 || $tx_dx1 > 0 || $tx_ix1 > 0)
{
$tx_status = 1;
if ($tx_cx1 > $tx_ix1)
{
$t_ann 	= 'Все отлично.';
}
else if ($tx_cx1 == 0 && $tx_ix1 > 0)
{
$t_ann 	= 'Некому раздавать торрент, если у вас есть этот файл(ы), помогите, станьте на раздачу.';
}
else if ($tx_dx1 > 0 && $tx_cx1 < 1 && $tx_ix1 < 1)
{
$t_ann 	= 'Торрент не активен.';
}
else
{
$tx_status = 1;
$t_ann 	= 'После скачивания, не покидайте раздачу.';
}
}
}

$torrentseeds      = $tx_cx1;
$torrentpeers      = $tx_ix1;
$torrentsnatched   = $tx_dx1;
$now        = sqlesc(get_date_time());


mysql_query("UPDATE torrents SET seeders=" . $torrentseeds . ", leechers=" .$torrentpeers . ", times_completed=" . $torrentsnatched . ", scrape_time = " . $now  . " WHERE id = " . $id . " AND scrape = 'yes'") or sqlerr(__FILE__,__LINE__); 


////// end torrent class (torrent scarping)   
    
}



?>