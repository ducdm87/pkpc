<?php defined('_JEXEC') or die('Restricted access'); ?>
<style type="text/css">
#yos_about {
	width:80%;
	overflow:hidden;	
	color: #4C608B;
	text-align: left;
	margin: 0;	
	font-size: 11px;
	font-weight: normal;
	font-family: 'Andale Mono', sans-serif;
	
}

#title_about {	
	font-weight: bold;
	font-size: 20px;
	overflow:hidden;
	text-align: center;
	color: #1A315A;
	padding: 3px;	
	height:25px;
}

#content_about {
	padding: 10px;
}

#developer_about {
	padding: 10px;
}
#yos_about .cron
{
	background-color:#DDDDC5;
	color:#000000;
	font-size:12px;
	padding:10px;
	overflow:hidden;
	
}

.link
{
	background-color:#FFFFFF;
	line-height:20px;
	padding-left:10px;
	padding-right:10px;
	width:70%;
}
.clr
{
	clear:both;
}
</style>
<?php $cronjob_link = JRoute::_(JURI::root().'index.php?option=com_yos_translator&task=cron&croncode='.$this->croncode); ?>
<div align="center">
<div id="yos_about">
	<div class="cron"> click 
		<a href="<?php echo $cronjob_link; ?>" target="_blank" >here</a> to run cron job 
		<br />  
		or copy link
	    	<?php echo $cronjob_link; ?>
	    <br />
	    Example of cronjob setting (linux server):<br />
	    */15 * * * * wget '<?php echo $cronjob_link; ?>' >> /dev/null 2>&1
	</div>
	<div id="title_about">
		Yos Translator
	</div>
	<div id="content_about">
		<p style="margin-bottom: 0in;">
		<strong>Yos Translator</strong> is a semi-auto translator extension for Joomla 1.5.x.</p>
<p style="margin-bottom: 0in;">Yos Translator is supported by <a title="Google Translate" href="http://translate.google.com"><strong>Google Translate</strong></a>. Using Yos Translator, you can easily translate your articles to any language which is available on Google Translate.</p>
<p style="margin-bottom: 0in;">Yos Translator works with <a title="Joomfish" href="http://www.joomfish.net"><strong>Joomfish</strong></a> which is a great Joomla extension. With Joomfish you can make your website to supports multiple languages very easily.</p>

<p style="margin-bottom: 0in;">Yos Translator is integrated in <strong>AJAX</strong> technology, and you can translate thousands articles to other languages with just a few clicks.</p>
<p style="margin-bottom: 0in;">Yos Translator provides two options are "Edit All" and <b>"Translate One"</b>. <b>"Translate All"</b> mode help you to fastly translate many items to other languages. "Edit One" mode allow you translate just one item carefully. In this mode, you can edit translated contents after Yos translator help you to do it.</p>
<p style="margin-bottom: 0in;">
		</p>
		
		<p style="text-align: center;">
			<img src="components/com_yos_translator/assets/images/icon-256-translator.png"/>
		</p>
	</div>
	<div id="developer_about">
		Developers: <br/>
		<ul>
			<font style="font-weight:normal;">
			<li><a href="mailto:minhna@f5vietnam.com">Minh Nguyen Anh</a></li>
			<li><a href="mailto:ducdm@f5vietnam.com">Dam Manh Duc</a></li>
			<li><a href="mailto:sonlv@f5vietnam.com">Son Le Van</a></li>
			<li><a href="http://www.yopensource.com">www.yopensource.com</a></li>
			</font>
		</ul>	
		Info:<br/>
		<font style="font-weight:normal;">		
		&nbsp;&nbsp;Version: This version is <?php echo $this->get('Version'); ?>&nbsp;
		<?php		
		if ($this->checkversion) {
			echo '<a href="http://www.yopensource.com/"><font color="red">New version is available!</font></a>&nbsp;&nbsp;&nbsp;';
			echo '<a title="Upgrade" href="index.php?option=com_yos_translator&amp;task=upgrade.doupdate&amp;version='.$this->get('Version').'&amp;url='.$this->get('URL').'&amp;pc='.$this->get('PC').'"><b>Upgrade Now!</b></a>';
			
		} else {
			echo 'your version is latest!';
		}
		if ($this->checkbackup) {
			echo '&nbsp;&nbsp;&nbsp;<a title="Backup" href="index.php?option=com_yos_translator&amp;task=upgrade.getbackup&amp;version='.$this->get('Version').'&amp;url='.$this->get('URL').'&amp;pc='.$this->get('PC').'"><b>Undo Upgrade Now!</b></a>';
			echo '&nbsp;&nbsp;&nbsp;<a title="Get Backup File" href="index.php?option=com_yos_translator&amp;task=upgrade.getFileBackup"><b>Get Backup File!</b></a>';
		}
		?>
		<br/>
		&nbsp;&nbsp;Copyright: &copy; 2010 YOS Team. All rights reserved.<br />		
		</font>
	</div>
</div>
</div>
	
