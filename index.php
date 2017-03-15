<?php
require_once('config.inc.php');
require_once('langs.inc.php');

include_once('Shaker.php');

$shaker = Shaker::getInstance();
$shaker->init($Lang);
$episode = $shaker->getEpisode();
$ep = $shaker->getCurrentEpisodeKey();
$current_episode = $shaker->getCurrentEpisodeName();

if ($shaker->isTinyBox()) {
    $PageUrl = "http://".$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
} else {
    $PageUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

if ($current_episode) {
    $files = $shaker->getEpisodeFiles();
	$filesnbr = count($files);
?>
<!DOCTYPE html>
<html lang="<?php echo $Lang ?>">
<head>
<meta charset="utf-8">
<title><?php echo $shaker->getCurrentEpisodeTitle().' - '.$Title; ?></title>
<link rel="stylesheet" type="text/css" href="design/style.php" />
<link rel="image_src" href="<?php echo $FacebookImageUrl; ?>" type="image/x-icon" />
<meta name="description" content="<?php echo $Description; ?>">
<link rel="alternate" type="application/rss+xml" title="<?php echo $Title; ?>" href="rss.php?lang=<?php echo $Lang; ?>" />
<meta name="viewport" content="width=<?php echo $ImageWidth+40; ?>, user-scalable=no" />
<script type="text/javascript" src="design/tinyshaker.js"></script>
<style type="text/css">
.pagination li { width:<?php echo (substr($ImageWidth, 0, -2)*$filesnbr/100).'px'; ?>; }
<?php if(!$shaker->isTinyBox()): ?>
#wrapper {margin-top:10px}
<?php endif ?>
</style>
</head>
<body>
<div id="wrapper">
<?php
	if (!$shaker->isTinyBox()) {
		if (count($Languages) > 1) {
            echo '<div id="languages">';
            foreach ($Languages as $lg) {
                if ($UrlRewriting) {
                    $urlLanguage = $lg.'-'.($ep+1);
                } else {
                    $urlLanguage = '?lang='.$lg.'&ep='.($ep+1);
                }
                echo '<a href="' . $urlLanguage . '">' . $lg . '</a> ';
            }
            echo '</div>';
		}

		if ($ShowTitle=='1') { echo '<h1>'.$shaker->getCurrentEpisodeTitle().'</h1>'; }
    }
?>
	<div>
		<div id="tbm">
			<ul id="slides">
<?php
    $i = 1;
    foreach ($files as $filename) {
        if (stripos($filename,'txt') != 0) {
            echo '<li class="content" onclick="tbm.move(+1)"><img width="0" height="0" name="img'.$i.'" />';
            include($filename);
            echo '</li>';
            $i++;
        } else {
            if ($i == $filesnbr) {
                echo '<li><img src="'.$filename.'" width="'.$ImageWidth.'" height="'.$ImageHeight.'" alt="'.basename($filename,strrchr($filename,'.')).'" onclick="tbm.move(+1)" /></li>';
            } else {
                echo '<li><script type="text/javascript">document.write("<img width=\"'.$ImageWidth.'\" height=\"'.$ImageHeight.'\" alt=\"'.basename($filename,strrchr($filename,'.')).'\" name=\"img'.$i.'\" onclick=\"tbm.move(+1)\" />")</script><noscript><img src="'.$filename.'" width="'.$ImageWidth.'" height="'.$ImageHeight.'" alt="'.basename($filename,strrchr($filename,'.')).'" /></noscript></li>';
            }
            $i++;
        }
    }
?>
<?php if ($Support == '1' || ($Support != '0' && $shaker->isTinyBox())): ?>
				<li class="content">
					<div id="support">
					<?php include('templates/link_rss.inc.php'); ?>
					<?php include('templates/link_facebook_share.inc.php'); ?>
					<?php include('templates/link_twitter_share.inc.php'); ?>
					<?php include('templates/link_embed.inc.php'); ?>
					</div>
<?php   if (!empty($FacebookCommentsAppId)): ?>
					<div id="comments">
						<h2><?php echo _('Comments'); ?></h2>
						<div id="fb-root"></div><script src="http://connect.facebook.net/<?php echo $LLang; ?>/all.js#appId=<?php echo $FacebookCommentsAppId ?>&amp;xfbml=1"></script><fb:comments href="<?php echo urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" num_posts="1" width="<?php echo $ImageWidth-40; ?>"></fb:comments>
					</div>
<?php   endif ?>
				</li>
<?php endif ?>
			</ul>
		</div>
	</div>
	<ul id="pagination" class="pagination">
<?php
    $fileMostRecentTime = 0;
    $episodeStartTime = filemtime($files[0]);
    foreach ($files as $filename) {
        $ft = filemtime($filename);
        if ($ft > $fileMostRecentTime) {
            $fileMostRecentTime = $ft;
        }
    }

    $i = 0;
    $first = 'first';
    foreach ($files as $filename) {
        $ft = filemtime($filename);
        $formattedDate = date(_('PhpDateFormat'), $ft);
        $fileBasename = basename($filename, strrchr($filename, '.'));
        $fileIsFlaggedNew = (strpos($filename, '_new') !== false);

        $updt = '&nbsp;';
        $updt_txt = '';
        if ((($ft > ($fileMostRecentTime-3600)) && ($ft>($episodeStartTime+3600)) && $ShowUpdt) || $fileIsFlaggedNew) {
            $updt = 'new';
            $updt_txt = '&bull;';
        }

        else if($i == $filesnbr - 1) {
            $first = 'last';
        } else {
            $first = '';
        }

        echo '<li onclick="tbm.pos('.$i.')" title="'.$formattedDate.' : '.$fileBasename.'" class="'.$updt.' '.$first.'">'.$updt_txt.'</li>';
        $i++;
    }
    if ($Support == '1' || ($Support != '0' && $shaker->isTinyBox())) {
        echo '<li onclick="tbm.pos('.$i.')" title="'._('SupportAndComment').'" class="comments"><img src="design/bubble.png" alt="'._('SupportAndComment').'" /></li>';
    }

    if (!$shaker->isTinyBox()) {
?>
	</ul>
<?php
        if (array_key_exists(($ep-1), $episode) || array_key_exists(($ep+1), $episode)) {
            if ($ShowTitle == '2') {
                echo '<h1>'.$episode[$ep].'</h1>';
            }
            echo '<hr/><ul id="episodes">';
            if (array_key_exists(($ep-1), $episode)) {
                if($UrlRewriting) {
                    echo '<li id="prev"><a href="'.$Lang.'-'.$ep.'" title="'.$episode[$ep-1].'">&laquo; '._('PrevEpisode').'</a></li>';
                } else {
                    echo '<li id="prev"><a href="?lang='.$Lang.'&ep='.($ep).'" title="'.$episode[$ep-1].'">&laquo; '._('PrevEpisode').'</a></li>';
                }
            } else {
                echo '<li id="prev">&nbsp;</li>';
            }
            echo '<ul class="list"><li>'._('Episodes').' : </li>';
            $i = 1;
            foreach ($episode as $e) {
                if ($i != $ep+1) {
                    if ($UrlRewriting) {
                        echo '<li>[<a href="'.$Lang.'-'.$i.'" title="'.$episode[$i-1].'">'.$i.'</a>]</li>';
                    } else {
                        echo '<li>[<a href="?lang='.$Lang.'&ep='.$i.'" title="'.$episode[$i-1].'">'.$i.'</a>]</li>';
                    }
                } else {
                    echo '<li>['.$i.']</li>';
                }
                $i++;
            }
            echo '</ul>'; // end of ul.list
            if (array_key_exists(($ep+1), $episode)) {
                if($UrlRewriting) {
                    echo '<li id="next"><a href="'.$Lang.'-'.($ep+2).'" title="'.$episode[$ep+1].'">'._('NextEpisode').' &raquo;</a></li>';
                } else {
                    echo '<li id="next"><a href="?lang='.$Lang.'&ep='.($ep+2).'" title="'.$episode[$ep+1].'">'._('NextEpisode').' &raquo;</a></li>';
                }
            } else {
                echo '<li id="next">&nbsp;</li>';
            }
            echo '</ul>'; // end of ul#episodes
        }
?>
	<hr/>
    <ul id="viral">
		<li><?php include('templates/link_rss.inc.php'); ?></li>
		<li><?php include('templates/link_facebook_share.inc.php'); ?></li>
		<li><?php include('templates/link_twitter_share.inc.php'); ?></li>
		<li><?php include('templates/link_embed.inc.php'); ?></li>
    </ul>
<?php
        if (!empty($FacebookCommentsAppId)) {
            $UrlComments = '';
            if ($Support=='2') {
                $UrlComments = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            } else if ($Support=='3') {
                $UrlComments = $Url;
            }
            if ($UrlComments) {
                echo '<div id="comments"><h2>'._('Comments').'</h2><div id="fb-root"></div><script src="http://connect.facebook.net/'.$LLang.'/all.js#appId='.$FacebookCommentsAppId.'&amp;xfbml=1"></script><fb:comments href="'.$Url.'" num_posts="3" width="'.($ImageWidth-40).'"></fb:comments></div>';
            }
        }

        echo '<div id="credits">'._('PoweredBy').' <a href="http://julien.falgas.fr/tinyshaker">TinyShaker</a><br/>'.$Credits.'</div>';
    } //fin du if($shaker->isTinyBox()!=1)
?>

</div>
<script type="text/javascript">
//liste des images du dossier
var imgs = new Array(
			<?php
    $i = 0;
    foreach ($files as $filename) {
        if (stripos($filename,'txt') == 0) {
            if ($i!=count($files)-1) {
                echo '"'.$filename.'",';
            } else {
                echo '"'.$filename.'");last='.$i.';';
            }
        } else {
            sort($files);
            if ($i!=count($files)-1) {
                echo '"design/pixel.png",';
            } else {
                echo '"design/pixel.png");last='.$i.';';
            }
        }
        $i++;
    }
    if ((array_key_exists(($ep-1), $episode)) && !$shaker->isTinyBox()) {
        if ($UrlRewriting) {
            echo 'epprev="'.$Lang.'-'.($ep).'";';
        } else {
            echo 'epprev="?lang='.$Lang.'&ep='.($ep).'";';
        }
    } else {
        echo 'epprev=0;';
    }
    if ((array_key_exists(($ep+1), $episode)) && !$shaker->isTinyBox()) {
        if ($UrlRewriting) {
            echo 'epnext="'.$Lang.'-'.($ep+2).'";';
        } else {
            echo 'epnext="?lang='.$Lang.'&ep='.($ep+2).'";';
        }
    } else {
        echo 'epnext=0;';
    }

    echo 'preload='.$Preload.';';
?>
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
<?php include('templates/google_analytics.inc.php'); ?>
</body>
</html>
<?php
}
