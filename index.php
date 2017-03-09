<?php
require_once('config.inc.php');
require_once('langs.inc.php');

$path = 'episodes/' . $Lang . '/';
$dir = scandir($path, SCANDIR_SORT_ASCENDING);
$episode = array();
foreach ($dir as $d) {
    if ($d[0] == '.') continue;
    $episode[] = $d;
}

if (isset($_GET["ep"])&&$_GET["ep"]>0) { $ep=$_GET["ep"]-1; } else {$ep=0;}
if (isset($_GET["tb"])&&$_GET["tb"]>0) { $Tinybox=$_GET["tb"]; } else {$Tinybox=0;}
$current_episode=$episode[$ep];

if (isset($_GET["tb"])) {
$PageUrl="http://".$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
} else {
$PageUrl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

if ( $directory = opendir($path."/".$current_episode."/") ) {
		while ( ( $file = readdir( $directory ) ) !== false ) {
			if($file!="."&&$file!="..") {
				$files[] = $path."/".$current_episode."/".$file;
			}
		}
	}
	sort($files);
	$filesnbr = count($files);
?>
<!DOCTYPE html>
<html lang="<?php echo $Lang ?>">
<head>
<meta charset="utf-8">
<title><?php echo $episode[$ep].' - '.$Title; ?></title>
<link rel="stylesheet" type="text/css" href="design/style.php" />
<link rel="image_src" href="<?php echo $FacebookImageUrl; ?>" type="image/x-icon" />
<meta name="description" content="<?php echo $Description; ?>">
<link rel="alternate" type="application/rss+xml" title="<?php echo $Title; ?>" href="rss.php?lang=<?php echo $Lang; ?>" />
<meta name="viewport" content="width=<?php echo $ImageWidth+40; ?>, user-scalable=no" />
<script type="text/javascript" src="design/tinyshaker.js"></script>
<style type="text/css">
.pagination li { width:<?php echo (substr($ImageWidth, 0, -2)*$filesnbr/100).'px'; ?>; }
</style>
</head>
<body>
	<?php
	if($Tinybox==0) {

	echo '<div id="wrapper" style="margin-top:10px;">';
		$NbLanguages = count($Languages);
		if ($NbLanguages>1) {
		echo '<div id="languages">';
		$i=0;
		while($i<$NbLanguages) {
		if($UrlRewriting=='1') { echo '<a href="'.$Languages[$i].'-'.($ep+1).'">'.$Languages[$i].'</a> '; }
		else { echo '<a href="?lang='.$Languages[$i].'&ep='.($ep+1).'">'.$Languages[$i].'</a> '; }
		$i++;
		}
		echo '</div>';
		}

		if ($ShowTitle=='1') { echo '<h1>'.$episode[$ep].'</h1>'; }
	} else { echo '<div id="wrapper">'; }
	?>
	<div>
		<div id="tbm">
			<ul id="slides">
				<?php
				$i=0;
				foreach ($files as $filename) {
					if ($i==0) {$i++;}
					if(stripos($filename,'txt') != 0) {
						echo '<li class="content" onclick="tbm.move(+1)"><img width="0" height="0" name="img'.$i.'" />';
						include($filename);
						echo '</li>';
						$i++;
					} else {
						if($i==$filesnbr) {
						echo '<li><img src="'.$filename.'" width="'.$ImageWidth.'" height="'.$ImageHeight.'" alt="'.basename($filename,strrchr($filename,'.')).'" onclick="tbm.move(+1)" /></li>';
						} else {
						echo '<li><script type="text/javascript">document.write("<img width=\"'.$ImageWidth.'\" height=\"'.$ImageHeight.'\" alt=\"'.basename($filename,strrchr($filename,'.')).'\" name=\"img'.$i.'\" onclick=\"tbm.move(+1)\" />")</script><noscript><img src="'.$filename.'" width="'.$ImageWidth.'" height="'.$ImageHeight.'" alt="'.basename($filename,strrchr($filename,'.')).'" /></noscript></li>';
						}
						$i++;
					}
				}
				?>
				<?php if (($Support=='1')||(($Support!='0')&&($Tinybox!=0))) { ?>
				<li class="content">
					<div id="support">
					<a href="rss.php" class="button feed"><?php echo _('Subscribe'); ?></a>
					<a href="http://www.facebook.com/share.php?u=<?php echo urlencode($PageUrl); ?>" class="button facebook"><?php echo _('Share'); ?></a>
					<a href="http://twitter.com/share" class="button twitter"><?php echo _('Tweet'); ?></a>
					<a href="javascript:TINY.box.show({url:'<?php echo $Url; ?>design/tinybox.php?PageUrl=<?php echo $PageUrl; ?>',width:480,height:360})" class="button website"><?php echo _('Embed'); ?></a>
					</div>
					<div id="comments">
					<h2><?php echo _('Comments'); ?></h2>
					<div id="fb-root"></div><script src="http://connect.facebook.net/<?php echo $LLang; ?>/all.js#appId=23029976184&amp;xfbml=1"></script><fb:comments href="<?php echo urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" num_posts="1" width="<?php echo $ImageWidth-40; ?>"></fb:comments>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<ul id="pagination" class="pagination">
		<?php
			$i=0;
			$t=0;
			$ft1=filemtime($files[0]);
			foreach ($files as $filename) {$ft=filemtime($filename);if ($ft>$t){$t=$ft;}}
			foreach ($files as $filename) {
					if(((filemtime($filename)>($t-3600))&&(filemtime($filename)>($ft1+3600))&&($ShowUpdt=='1'))||(strpos($filename, '_new') !== false)){$updt='new';}else{$updt='&nbsp;';}
					if($updt=='new'){$updt_txt='&bull;';}else{$updt_txt='';}
					if($i==0){$first='first';}else if($i==$filesnbr-1){$first='last';}else{$first='';}
					echo '<li onclick="tbm.pos('.$i.')" title="'.date("d/m/Y", filemtime($filename)).' : '.basename($filename,strrchr($filename,'.')).'" class="'.$updt.' '.$first.'">'.$updt_txt.'</li>';
					$i++;
			}
			if (($Support=='1')||(($Support!='0')&&($Tinybox!=0))) {
				echo '<li onclick="tbm.pos('.$i.')" title="'._('SupportAndComment').'" class="comments"><img src="design/bubble.png" alt="'._('SupportAndComment').'" /></li>';
			}

			if($Tinybox==0) {
		?>
	</ul>
	<?php if(array_key_exists(($ep-1), $episode)||array_key_exists(($ep+1), $episode)) {
		if ($ShowTitle=='2') { echo '<h1>'.$episode[$ep].'</h1>'; }
		echo '<hr/><ul id="episodes">';
		if (array_key_exists(($ep-1), $episode)) { if($UrlRewriting=='1') { echo '<li id="prev"><a href="'.$Lang.'-'.$ep.'" title="'.$episode[$ep-1].'">&laquo; '._('PrevEpisode').'</a></li>'; } else { echo '<li id="prev"><a href="?lang='.$Lang.'&ep='.($ep).'" title="'.$episode[$ep-1].'">&laquo; '._('PrevEpisode').'</a></li>'; } } else { echo '<li id="prev">&nbsp;</li>'; }
		echo '<ul class="list"><li>'._('Episodes').' : </li>';
		for($i=1;$i<=count($episode); $i++) { if($i!=$ep+1) { if($UrlRewriting=='1') { echo '<li>[<a href="'.$Lang.'-'.$i.'" title="'.$episode[$i-1].'">'.$i.'</a>]</li>'; } else { echo '<li>[<a href="?lang='.$Lang.'&ep='.$i.'" title="'.$episode[$i-1].'">'.$i.'</a>]</li>'; } } else { echo '<li>['.$i.']</li>'; } }
		echo '</ul>';
		if (array_key_exists(($ep+1), $episode)) { if($UrlRewriting=='1') { echo '<li id="next"><a href="'.$Lang.'-'.($ep+2).'" title="'.$episode[$ep+1].'">'._('NextEpisode').' &raquo;</a></li>'; } else { echo '<li id="next"><a href="?lang='.$Lang.'&ep='.($ep+2).'" title="'.$episode[$ep+1].'">'._('NextEpisode').' &raquo;</a></li>'; } } else { echo '<li id="next">&nbsp;</li>'; }
		echo '</ul>';
	}
	?>
	<hr/>
		<ul id="viral">
		<li><a href="rss.php?lang=<?php echo $Lang; ?>" class="button feed"><?php echo _('Subscribe'); ?></a></li>
		<li><a href="http://www.facebook.com/share.php?u=<?php echo urlencode($PageUrl); ?>" class="button facebook"><?php echo _('Share'); ?></a></li>
		<li><a href="http://twitter.com/share" class="button twitter"><?php echo _('Tweet'); ?></a></li>
		<li><a href="javascript:TINY.box.show({url:'<?php echo $Url; ?>design/tinybox.php?PageUrl=<?php echo $PageUrl; ?>',width:480,height:360})" class="button website"><?php echo _('Embed'); ?></a></li>
		</ul>
		<?php
		if ($Support=='2') {
			echo '<div id="comments"><h2>'._('Comments').'</h2><div id="fb-root"></div><script src="http://connect.facebook.net/'.$LLang.'/all.js#appId=23029976184&amp;xfbml=1"></script><fb:comments href="'.urlencode("http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]).'" num_posts="3" width="'.($ImageWidth-40).'"></fb:comments></div>';
		} else if ($Support=='3') {
			echo '<div id="comments"><h2>'._('Comments').'</h2><div id="fb-root"></div><script src="http://connect.facebook.net/'.$LLang.'/all.js#appId=23029976184&amp;xfbml=1"></script><fb:comments href="'.$Url.'" num_posts="3" width="'.($ImageWidth-40).'"></fb:comments></div>';
		}
			echo '<div id="credits">'._('PoweredBy').' <a href="http://julien.falgas.fr/tinyshaker">TinyShaker</a><br/>'.$Credits.'</div>';

		} //fin du if($Tinybox!=1)
		?>

</div>
<script type="text/javascript">
//liste des images du dossier
var imgs = new Array(
			<?php
				$i=0;
				foreach ($files as $filename) {
					if(stripos($filename,'txt') == 0) {
						if($i!=count($files)-1) {
							echo '"'.$filename.'",';
							$i++;
						} else {
							echo '"'.$filename.'");last='.$i.';';
							$i++;
						}
					} else {
						if($i!=count($files)-1) {
							echo '"design/pixel.png",';
							$i++;
						} else {
							echo '"design/pixel.png");last='.$i.';';
							$i++;
						}
					}
				}
				if ((array_key_exists(($ep-1), $episode))&&($Tinybox==0)) { if($UrlRewriting=='1') { echo 'epprev="'.$Lang.'-'.($ep).'";'; } else { echo 'epprev="?lang='.$Lang.'&ep='.($ep).'";';} } else { echo 'epprev=0;';}
				if ((array_key_exists(($ep+1), $episode))&&($Tinybox==0)) { if($UrlRewriting=='1') {  echo 'epnext="'.$Lang.'-'.($ep+2).'";'; } else { echo 'epnext="?lang='.$Lang.'&ep='.($ep+2).'";'; } } else { echo 'epnext=0;';}

			echo 'preload='.$Preload.';'; ?>
var tbm=new TINY.shaker.shake('tbm',{
	id:'slides',
	navid:'pagination',
	activeclass:'current',
	position:0
});
document.onkeydown=function(e){
	e = e || window.event;
	if (e.keyCode) code = e.keyCode;
	else if (e.which) code = e.which;
	if(code == 37) { tbm.move(-1); }
	if(code == 39) { tbm.move(+1); }
}
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $IDGoogleAnalytics; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
