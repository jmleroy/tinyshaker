<?php header("Content-type: text/css; charset=UTF-8");
require_once('../config.inc.php');
//header('Cache-Control: max-age=3600, must-revalidate');

/**
 * get color with difference
 * @param string $hexStr hexadecimal string
 * @param int $diff
 * @return array|bool
 */
function getColor($hexStr, $diff = 0) {
    if($diff > 255) {
        $diff = 255;
    }
    $color = preg_replace('/[^0-9A-Fa-f]/', '', $hexStr);

    if (strlen($color) == 3) {
        $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
    }

    if (strlen($color) == 6) {
        $rgb = str_split($color, 2);
        $ret = 0;
        foreach($rgb as $i => $c) {
            $c = hexdec($c) + $diff;
            if($c > 255) {
                $c = 255;
            } elseif($c < 1) {
                $c = 0;
            }
            $ret += $c * pow(256, (2 - $i));
        }

        return sprintf("#%'06X", $ret);
    }

    return '#000000';
}

$Color1 = getColor($Color);
$Color1Lighter = getColor($Color, 6);
$Color1Darker = getColor($Color, -6);
$Color2 = getColor($Color, 80);
$Color2Alt = getColor($Color, 170);
?>
* {margin:0; padding:0}
body {background:<?php echo $BgColor; ?>;font-family:Verdana,sans-serif;color:<?php echo $Color2; ?>;}
a {color:<?php echo $Color2Alt; ?>;text-decoration:none;}
a:hover{text-decoration:underline;color:<?php echo $HlColor; ?>;}
h1 {color:<?php echo $Color2Alt; ?>;margin: 0 0 5px 0;}

#languages {font-size:.8em; text-align: right;float:right;}

#wrapper {width:<?php echo $ImageWidth; ?>; margin: 0 auto}
#tbm, #slides li {width:<?php echo $ImageWidth; ?>; height:<?php echo $ImageHeight; ?>;}
#slides {width:<?php echo $ImageWidth; ?>; height:<?php echo $ImageHeight; ?>;position:relative; list-style:none; overflow-y: auto; overflow-x: hidden; overflow : -moz-scrollbars-vertical;}
#slides:hover { cursor:pointer;}

.pagination {list-style:none;width:100%;display:table;margin:10px 0;
-moz-border-radius: 10px;
border-radius: 10px;
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0, <?php echo $Color1Lighter; ?>),
    color-stop(0.9, <?php echo $Color1; ?>),
    color-stop(0.1, <?php echo $Color1Darker; ?>)
);
background-image: -moz-linear-gradient(
    center bottom,
    <?php echo $Color1Lighter; ?> 0%,
    <?php echo $Color1; ?> 90%,
    <?php echo $Color1Darker; ?> 10%
);
background-color: <?php echo $Color1; ?>;
}
.pagination li {cursor:pointer;display:table-cell;text-align:center;font-weight:bold;border-color:transparent;border-width:1px 0;border-style:solid;height:16px;}
.pagination li:hover {border-color:<?php echo $HlColor; ?>;}
li.first{
-moz-border-radius-topleft: 10px;
-moz-border-radius-topright: 0px;
-moz-border-radius-bottomright: 0px;
-moz-border-radius-bottomleft: 10px;
border-top-left-radius: 10px;
border-top-right-radius: 0px;
border-bottom-right-radius: 0px;
border-bottom-left-radius: 10px;
}
li.last {
-moz-border-radius-topleft: 0px;
-moz-border-radius-topright: 10px;
-moz-border-radius-bottomright: 10px;
-moz-border-radius-bottomleft: 0px;
border-top-left-radius: 0px;
border-top-right-radius: 10px;
border-bottom-right-radius: 10px;
border-bottom-left-radius: 0px;
}
li#current {
-moz-border-radius-topright: 10px;
-moz-border-radius-bottomright: 10px;
border-top-right-radius: 10px;
border-bottom-right-radius: 10px;
}
.pagination li.comments {
-moz-border-radius: 10px;
border-radius: 10px;
width: 36px;
padding-top:4px;
}
li#current, li#past, .pagination li.comments {
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0, <?php echo $Color2Alt; ?>),
    color-stop(0.9, <?php echo $Color2; ?>),
    color-stop(0.1, <?php echo $Color2Alt; ?>)
);
background-image: -moz-linear-gradient(
    center bottom,
    <?php echo $Color2Alt; ?> 0%,
    <?php echo $Color2; ?> 90%,
    <?php echo $Color2Alt; ?> 10%
);
background-color: <?php echo $Color2; ?>;
}
li.new {color:<?php echo $HlColor; ?>;}

li.content { width:<?php echo $ImageWidth; ?>; height:<?php echo $ImageHeight; ?>; overflow:auto;}

hr{ margin: 16px 0; border: 1px dashed <?php echo $Color2; ?>; border-width:1px 0 0 0;color: transparent; background-color: transparent; height: 1px;}

#episodes {list-style:none;width:100%;margin-top:5px;display:table;}
#episodes li {display:table-cell;font-size:.8em;width:150px;}
#episodes li#prev {}
#episodes li#next {text-align:right;}

#episodes ul.list {display:table-cell;text-align:center;}
#episodes ul.list li {display:inline;}

#viral { list-style:none;}
#viral li { margin: 8px 0 3px;; float:left;}
#viral .button { padding-left:20px;font-size:.8em;margin-right:7px; }
#viral .feed { background:url(feed.png) no-repeat left;}
#viral .facebook { background:url(facebook.png) no-repeat left;}
#viral .twitter { background:url(twitter.png) no-repeat left;}
#viral .website{ background:url(website.png) no-repeat left;}

#comments {clear:both;background:#F2F2F2;border:<?php echo $Color2; ?> 5px solid;padding:5px; height:<?php echo (substr($ImageHeight, 0, -2)-100).'px'; ?>;overflow:auto;}

#support { margin: 0 auto 0 auto; width:480px;}
#support .button { padding: 50px 0 10px 0; width: 120px; display:block; float:left; text-align:center;}
#support .feed { background:url(feed-48x48.png) no-repeat center top;}
#support .facebook { background:url(facebook-48x48.png) no-repeat center top;}
#support .twitter { background:url(twitter-48x48.png) no-repeat center top;}
#support .website { background:url(website-48x48.png) no-repeat center top;}

#credits { font-size:.6em;float:right; margin-top: 8px;padding-bottom: 8px;}

.tbox {position:absolute; display:none; padding:14px 17px; z-index:900;color:#000;}
.tinner {padding:15px; -moz-border-radius:5px; border-radius:5px; background:#fff url(preload.gif) no-repeat 50% 50%; border-right:1px solid #fff; border-bottom:1px solid #fff;overflow:hidden;}
.tmask {position:absolute; display:none; top:0px; left:0px; height:100%; width:100%; background:<?php echo $HlColor; ?>; z-index:800}
