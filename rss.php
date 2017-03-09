<?php

// on détermine le type de document, ici du xml
//header('Content-Type: text/css');
header('Content-type: application/rss+xml, application/rdf+xml;q=0.8, application/atom+xml;q=0.6, application/xml;q=0.4, text/xml;q=0.4; charset=UTF-8') ;

require_once('config.inc.php');
require_once('langs.inc.php');

?>
<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title><?php echo $Title ?></title>
<link><?php echo $Url ?></link>
<description><?php echo $Description ?></description>
<atom:link href="<?php echo $Url ?>rss.php?lang=<?php echo $Lang ?>" rel="self" type="application/rss+xml" />
<?php
$items = array();
$path = 'episodes/' . $Lang . '/';
$dir = scandir($path);
$i = 1;

foreach($dir as $d) {
    if($d[0] == '.') continue;
    $pathEpisode = $path . $d . '/';
    $files = scandir($pathEpisode, SCANDIR_SORT_ASCENDING);
    $firstFileOfEpisode = array_shift(array_diff($files, array('.', '..')));
    $pathToFirstFileOfEpisode = $pathEpisode . $firstFileOfEpisode;
    $pubDateOfEpisode = filemtime($pathToFirstFileOfEpisode);
    $item = array(
        'd' => $d,
        'pubDate' => date ('D, d M Y H:i:s', $pubDateOfEpisode) . ' GMT',
        'link' => $Url . ($UrlRewriting ? $Lang.'-'.$i : '?lang='.$Lang.'&amp;ep='.$i),
        'linkFile' => $Url . $pathToFirstFileOfEpisode,
    );
    $items[$pubDateOfEpisode] = $item;
    $i++;
}

krsort($items);

foreach($items as $item) {
    extract($item);
?>
	<item>
	<title><?php echo $d ?></title>
	<link><?php echo $link ?></link>
	<guid><?php echo $link ?></guid>
	<description><![CDATA[<a href="<?php echo $link ?>"><img src="<?php echo $linkFile ?>"><br><?php echo _('GoToEpisode', $d) ?></a>]]></description>
	<pubDate><?php echo $pubDate ?></pubDate>
	</item>
<?php
}
?>
</channel>
</rss>
