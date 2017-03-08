<?php require_once('../config.txt'); ?>
<code>
&lt;script type="text/javascript" src="<?php echo $Url; ?>design/tinybox.js"&gt;&lt;/script&gt;<br/>
&lt;style type="text/css"&gt;<br/>
.tbox {position:absolute; display:none; padding:14px 17px; z-index:900}<br/>
.tinner {padding:15px; -moz-border-radius:5px; border-radius:5px; background:<?php echo $BgColor; ?> url(<?php echo $Url; ?>preload.gif) no-repeat 50% 50%; border-right:1px solid <?php echo $BgColor; ?>; border-bottom:1px solid <?php echo $BgColor; ?>}<br/>
.tmask {position:absolute; display:none; top:0px; left:0px; height:100%; width:100%; background:<?php echo $HlColor; ?>; z-index:800}<br/>
&lt;/style&gt;<br/>
&lt;a href="javascript:TINY.box.show({iframe:'<?php echo $_GET['PageUrl'].'?tb=1'; ?>',width:<?php echo $ImageWidth+0; ?>,height:<?php echo $ImageHeight+40; ?>})"&gt;<?php echo $Title; ?>&lt;/a&gt;
</code>