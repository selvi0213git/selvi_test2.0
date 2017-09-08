<?php if(!defined('ABSPATH')) exit;?>
<div class="wrap">
	<div style="float:left;margin:7px 8px 0 0;width:36px;height:34px;background:url(<?php echo COSMOSFARM_MEMBERS_URL . '/images/icon-big.png'?>) left top no-repeat;"></div>
	<h1>
		코스모스팜 회원관리
		<a href="http://www.cosmosfarm.com/" class="page-title-action" onclick="window.open(this.href);return false;">홈페이지</a>
		<a href="http://www.cosmosfarm.com/threads" class="page-title-action" onclick="window.open(this.href);return false;">커뮤니티</a>
		<a href="http://www.cosmosfarm.com/support" class="page-title-action" onclick="window.open(this.href);return false;">고객지원</a>
		<a href="http://blog.cosmosfarm.com/" class="page-title-action" onclick="window.open(this.href);return false;">블로그</a>
	</h1>
	<p>코스모스팜 회원관리는 한국형 회원가입 레이아웃과 기능을 제공합니다.</p>
	
	<hr>
	
	<form method="post" action="<?php echo admin_url('admin-post.php')?>">
		<?php wp_nonce_field('cosmosfarm-members-exists-check-save', 'cosmosfarm-members-exists-check-save-nonce')?>
		<input type="hidden" name="action" value="cosmosfarm_members_exists_check_save">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">중복확인 설정</th>
					<td>
						<p class="description">회원가입 폼에서 입력 필드에 중복확인 버튼을 따로 추가하고 싶을 경우 사용하세요.</p>
						<p class="description">사용에 체크된 입력 필드는 회원별로 고유한 값만 등록 및 사용할 수 있습니다.</p>
						<p class="description">아이디와 이메일의 경우 체크되어 있지 않아도 항상 중복 중복확인을 사용합니다.</p>
					</td>
				</tr>
				<?php if(!$option->allow_email_login):?>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_members_exists[username]">아이디</label></th>
					<td>
						<label><input type="checkbox" id="cosmosfarm_members_exists_check[username]" name="cosmosfarm_members_exists_check[username]" value="username"<?php if(isset($option->exists_check['username']) && $option->exists_check['username'] == 'username'):?> checked<?php endif?>> 사용</label>
					</td>
				</tr>
				<?php endif?>
				<?php foreach(wpmem_fields() as $key=>$field):?>
					<?php if($field['type'] != 'email' && $field['type'] != 'text') continue?>
					<?php if(!$field['register']) continue?>
					<tr valign="top">
						<th scope="row"><label for="cosmosfarm_members_exists[<?php echo $key?>]"><?php echo $field['label']?></label></th>
						<td>
							<label><input type="checkbox" id="cosmosfarm_members_exists_check[<?php echo $key?>]" name="cosmosfarm_members_exists_check[<?php echo $key?>]" value="<?php echo $key?>"<?php if(isset($option->exists_check[$key]) && $option->exists_check[$key] == $key):?> checked<?php endif?>> 사용</label>
						</td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
		
		<p class="submit">
			<input type="submit" class="button-primary" value="변경 사항 저장">
		</p>
	</form>
	
	<hr>
	<iframe src="//www.cosmosfarm.com/display/size/320_100" frameborder="0" scrolling="no" style="margin-top:20px;width:320px;height:100px;border:none;"></iframe>
	<hr>
	<iframe src="//www.cosmosfarm.com/display/size/300_250" frameborder="0" scrolling="no" style="margin-top:20px;width:300px;height:250px;border:none;"></iframe>
</div>
<div class="clear"></div>