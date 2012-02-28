<?php
defined('_JEXEC') or die('Restricted access');
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_spa_content/assets/css/chiase.css');
$document->addScript(JURI::root().'modules/mod_spa_content/assets/js/plusone.js');
?>
<div class="spacontent_chiase">
<!--BEGIN HEADER-->
<?php if ($header) {
	echo '<h3 class="head"><span><strong>'.$header.'</strong></span></h3>';
}

$title	=	$document->getTitle();
$desc	=	$document->getDescription();
$desc	=	str_replace("\r\n","",$desc);
$link_current	=	JURI::current();
$title	=	str_replace(' ','+',$title);

?>
<!--END HEADER-->
<!--BEGIN CONTENT-->
<span class="clear"></span>
	<div class="chiase">
		<div style="margin-left: 10px;">
			<div class="share0">
			<ul>
			    <li>
				<a title="Chia sẻ lên Zing Me" target="_blank" href="http://link.apps.zing.vn/share?u=<?php echo $link_current; ?>&amp;t=<?php echo $title; ?>&amp;desc=<?php echo $desc; ?>">
					<img height="20" align="left" width="20" title="Zing" alt="Zing" src="<?php echo JURI::root(); ?>modules/mod_spa_content/assets/images/zing_icon.jpg">
				</a>
			  </li>
			  
			  <li class="linkhay">
				<a href="http://linkhay.com/submit?link_url=<?php echo $link_current; ?>&link_title=<?php echo htmlspecialchars($title); ?>&link_content=<?php echo htmlspecialchars($desc); ?>&link_media=0&utm_source=partner&utm_medium=embedded&utm_campaign=button" title="Chia sẻ trên LinkHay.com" target="_blank" class="retweet">&nbsp;</a>
			</li>
			<li class="govn">
			   <a title="Chia sẻ liên kết lên Mạng Việt Nam - Go.vn" target="_blank" href="http://my.go.vn/share.aspx?url=<?php echo $link_current; ?>&title=<?php echo htmlspecialchars($title); ?>&description=<?php echo htmlspecialchars($desc); ?>&name=www.chuyenkhoamat.com&detectMedia=0">
				<img height="20" style="border: medium none;" title="Go.vn" alt="Go.vn" src="<?php echo JURI::root(); ?>modules/mod_spa_content/assets/images/govn3_icon.jpg">		
			    </a>
			</li>
			  <li>
				<a rel="nofollow" target="_blank" href="http://de.facebook.com/sharer.php?u=<?php echo $link_current; ?>&t=<?php echo $title; ?>">
					<img height="20" align="left" width="20" title="Facebook" alt="Facebook" src="<?php echo JURI::root(); ?>modules/mod_spa_content/assets/images/facebook_icon.jpg" />
				</a>
				 </li>
			  <li>
				<a title="Twitter" rel="nofollow" target="_blank" href="http://twitter.com/home?status=<?php echo $link_current; ?>">
					<img height="20" align="left" width="20" title="Twitter" alt="Twitter" src="<?php echo JURI::root(); ?>modules/mod_spa_content/assets/images/twitter_icon.jpg"">
				</a>
				 </li>
			  <li>			
				<a rel="nofollow" target="_blank" href="http://www.google.com/bookmarks/mark?op=add&bkmk=<?php echo $link_current; ?>&title=<?php echo $title; ?>">
					<img height="20" align="left" width="20" title="Google Bookmarks" alt="Google Bookmarks" src="<?php echo JURI::root(); ?>modules/mod_spa_content/assets/images/google_icon.jpg">
				</a>
				 </li>
			  <li>
				<a title="Gửi bài này cho bạn bè qua yahoo" href="ymsgr:im?+&msg=<?php echo $title; ?>:<?php echo $link_current; ?>">
					<img height="20" align="left" width="20" title="Yahoo" alt="Yahoo" src="<?php echo JURI::root(); ?>modules/mod_spa_content/assets/images/yahoo_icon.jpg" />					
				</a>
				 </li>
			  </ul>
				
			</div>
			
			<!-- Place this tag where you want the +1 button to render -->
			<div class="googleclass" style=" margin:-2px 0 0; width:170px;">
				<g:plusone size="medium" annotation="inline"></g:plusone>
			</div>

				<!-- Place this render call where appropriate -->
				<script type="text/javascript">
					 window.___gcfg = {lang: 'vi'};  						
					 (function() {
   					 var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    					po.src = 'https://apis.google.com/js/plusone.js';
    					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  	})();
				</script>
		</div>
	</div>
<!--END CONTENT-->


<!--BEGIN FOOTER-->
<?php if ($footer) {
	echo '<div class="ckmsection">'.$footer.'</div>';
	}
?>
<!--END FOOTER-->
<div class="clr"></div>
</div>
