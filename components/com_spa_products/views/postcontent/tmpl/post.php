<?php

require_once(JPATH_COMPONENT_SITE.DS.'assets'.DS.'captcha'.DS.'lib'.DS.'recaptchalib.php');
$cparams 		= 	&JComponentHelper::getParams( 'com_spa_faq' );
$publickey		=	$cparams->get('publickey');
$enablecaptchar		=	$cparams->get('captchar');
$category = $this->list_cat;
$editor =& JFactory::getEditor();
$row	=	$this->postdata;
$uri		=& JFactory::getURI();

	?>
	
<div id="form_post">
	<h2>Liên hệ với bác sỹ</h2>
	<div class="" id="faq_message">
	</div>
	<form id="form1" action="<?php echo $uri->toString(); ?>" method="post" name="form1">
    <div class="addquestion">
        <div id="cauhoi">
            <div>
                Họ tên <span class="req">*</span></div>
            <input value="<?php if(isset($row['name'])) echo $row['name']; ?>" type="text" id="name" name="name">
            <hr>
            <ul>
                <li>
                	<div>Thông tin bệnh nhân</div>
                </li>
                <li>
                	<div class="center">Tuổi</div><input value="<?php if(isset($row['age'])) echo $row['age']; ?>" id="age" type="text" name="age" value="0">
                </li>
                <li>
                	<div class="center">Giới tính</div>
                	<select name="sex">
						<option <?php if(isset($row['sex']) and $row['sex'] == 1) echo 'select="selected"'; ?> value="1">Nam</option>
						<option <?php if(isset($row['sex']) and $row['sex'] == 0) echo 'select="selected"'; ?> value="0">Nữ</option>
					</select>
                </li>
                <li>
                    <div class="center">Cân nặng(kg)</div><input value="<?php if(isset($row['weight'])) echo $row['weight']; ?>" id="weight" type="text" name="weight" />
                </li>
                <li>
                    <div class="center">Chiều cao(cm)</div><input value="<?php if(isset($row['height'])) echo $row['height']; ?>" id="height" type="text" name="height" />
                </li>
            </ul>
            <hr>
            <ul>
                 <li>
                    <div>Email <span class="req">*</span></div><input value="<?php if(isset($row['email'])) echo $row['email']; ?>" type="text" id="email" name="email">
            	</li>
            	<li>
                	<div style="width: 77px;" class="center">Điện thoại <span class="req">*</span></div>
                	<input value="<?php if(isset($row['phone1'])) echo $row['phone1']; ?>" type="text" id="sdt" name="phone1">
                </li>
            </ul>
            <hr>
            <div>Địa chỉ</div>
            <input value="<?php if(isset($row['add'])) echo $row['add']; ?>" type="text" id="add" name="add">
            <hr>
            <div>Tiêu đề <span class="req">*</span></div>
            <input value="<?php if(isset($row['title'])) echo $row['title']; ?>" type="text" id="title" name="title">
            <hr>
            <div>Chọn bệnh <span class="req">*</span></div>
            	<select name="catid" id="catid">
            		<?php
            		$catid	=	$category[0]->id;
            		if (isset($row['catid'])) {
            			$catid	=	$row['catid'];
            		}
            			for($i=0; $i<count($category); $i++)
            			{
            				?>
            					<option <?php if($catid == $category[$i]->id) echo 'selected'; ?>  value="<?php echo $category[$i]->id; ?>"><?php echo $category[$i]->title; ?></option>
            				<?php
            			}
            		?>
				</select>
            <hr>
            <div>Triệu chứng</div><textarea  id="trieuchung" name="trieuchung"><?php if(isset($row['trieuchung'])) echo $row['trieuchung']; ?></textarea>
            <hr>
            <div>Tiền sử bệnh</div>
            <textarea id="tiensu" name="tiensu"><?php if(isset($row['tiensu'])) echo $row['tiensu']; ?></textarea>
            <hr>
            <div>Xét nghiệm và kết quả (nếu có)</div><textarea id="xetnghiem" name="xetnghiem"><?php if(isset($row['xetnghiem'])) echo $row['xetnghiem']; ?></textarea>
            <hr>
            <div>Các loại thuốc đã dùng (nếu có)</div><textarea id="thuocdadung" name="thuocdadung"><?php if(isset($row['thuocdadung'])) echo $row['thuocdadung']; ?></textarea>
            <hr>
            <div>Nội dung câu hỏi <span class="req">*</span></div>
            	<?php 
            	$question	=	'';
            	if(isset($row['question'])) $question = $row['question'];
            	echo $editor->display('question', $question , '75%', '400', '20', '25', false);
            	
            	?>            	
            <hr>
            <?php 
            	if ($enablecaptchar) {
            		?>
            		 <div>Ký tự bảo mật <span class="req">*</span></div>
		            	<?php echo recaptcha_get_html($publickey); ?>
		            <hr> 
            		<?php
            	}
            	
            	if (isset($row['message']) and $row['message'] != '') {
            		?>
            			<script>
            				window.addEvent('load', function(e){
        						alert("<?php echo $row['message']; ?>");
								if($('recaptcha_response_field'))
								{
									$('recaptcha_response_field').setStyle('border', '1px solid red');
									$('postquestion').focus();
									$('recaptcha_response_field').focus();
								}
            				});						
            			</script>
            		<?php
            	}
            ?>
           
            <div id="sendbt"><a id="postquestion" href="#">Gửi</a></div>

        </div>
    </div>    
    <input type="hidden" name="option" value="com_spa_faq" />
    <input type="hidden" name="task" value="save" />
    </form>
</div>