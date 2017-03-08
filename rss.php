<?php

// on détermine le type de document, ici du xml
header ( "Content-type: text/xml; charset=UTF-8" ) ;

require_once('config.txt');

if (isset($_GET["lang"])) { $Lang=$_GET["lang"];}
    
$rss = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>" ;
$rss .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">" ;
$rss .= "<channel>" ;
$rss .= "<title>".$Title."</title>" ;
$rss .= "<link>".$Url."</link>" ;
$rss .= "<description>".$Description."</description>" ;
$rss .= "<atom:link href=\"".$Url."rss.php?lang=".$Lang."\" rel=\"self\" type=\"application/rss+xml\" />";

$rep = "episodes/".$Lang."/";
$dir = opendir($rep); 
$i=1;
while (false !== ($d = readdir($dir))){
   if((is_dir($rep.$d))&&$d>'..') {
	//$dirt = new SplFileInfo($rep."/".$d);
	//$dirtime=date ("D, d M Y H:i:s", $dirt->getMTime());
	if ( $directory = opendir($rep.$d."/") ) {
					while ( ( $file = readdir( $directory ) ) !== false ) {
						if($file!="."&&$file!="..") {
						$files[] = $rep.$d."/".$file;
						}
					}
				}
	$dirtime=date ("D, d M Y H:i:s", filemtime($files[0]));
	// On crée l'item avec ces données
	$rss .= "<item>" ;
	$rss .= "<title>".$d."</title>"; 
	if ($UrlRewriting=='1') {
	$rss .= "<link>".$Url.$Lang."-".$i."</link>" ; 
	$rss .= "<guid>".$Url.$Lang."-".$i."</guid>" ;
	$rss .= "<description><![CDATA[<a href=\"".$Url.$Lang."-".$i."\"><img src=\"".$Url.$files[0]."\"><br>Accéder à l'épisode <em>".$d."</em></a>]]></description>" ; 
	} else {
	$rss .= "<link>".$Url."?lang=".$Lang."&amp;ep=".$i."</link>" ; 
	$rss .= "<guid>".$Url."?lang=".$Lang."&amp;ep=".$i."</guid>" ;
	$rss .= "<description><![CDATA[<a href=\"".$Url."?lang=".$Lang."&amp;ep=".$i."\"><img src=\"".$Url.$files[0]."\"><br>Accéder à l'épisode <em>".$d."</em></a>]]></description>" ; 
	
	}
	$rss .= "<pubDate>".$dirtime." GMT</pubDate>" ; 
	$rss .= "</item>" ;
	$i++;
   }
}
closedir($dir);
$rss .= "</channel>" ;
$rss .= "</rss>" ;

// On affiche le contenu XML
echo $rss;

?>