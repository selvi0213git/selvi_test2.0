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
		<?php wp_nonce_field('cosmosfarm-members-security-save', 'cosmosfarm-members-security-save-nonce')?>
		<input type="hidden" name="action" value="cosmosfarm_members_security_save">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_members_use_strong_password">강력한 비밀번호 사용</label></th>
					<td>
						<select id="cosmosfarm_members_use_strong_password" name="cosmosfarm_members_use_strong_password">
							<option value="">사용중지</option>
							<option value="1"<?php if($option->use_strong_password):?> selected<?php endif?>>사용</option>
						</select>
						<p class="description">복잡한 비밀번호를 반드시 사용하도록 합니다.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_members_save_login_history">로그인 기록 저장</label></th>
					<td>
						<select id="cosmosfarm_members_save_login_history" name="cosmosfarm_members_save_login_history">
							<option value="">사용중지</option>
							<option value="1"<?php if($option->save_login_history):?> selected<?php endif?>>사용</option>
						</select>
						<p class="description">언제 어디서 로그인을 시도했는지 IP주소와 성공 여부 등 정보를 저장합니다.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_members_use_login_protect">로그인 공격 보안</label></th>
					<td>
						<?php if($option->save_login_history):?>
						<select id="cosmosfarm_members_use_login_protect" name="cosmosfarm_members_use_login_protect">
							<option value="">사용중지</option>
							<option value="1"<?php if($option->use_login_protect):?> selected<?php endif?>>사용</option>
						</select>
						<br>
						비밀번호를
						<select id="cosmosfarm_members_login_protect_time" name="cosmosfarm_members_login_protect_time">
							<option value="1"<?php if($option->login_protect_time == '1'):?> selected<?php endif?>>1분</option>
							<option value="2"<?php if($option->login_protect_time == '2'):?> selected<?php endif?>>2분</option>
							<option value="3"<?php if($option->login_protect_time == '3'):?> selected<?php endif?>>3분</option>
							<option value="4"<?php if($option->login_protect_time == '4'):?> selected<?php endif?>>4분</option>
							<option value="5"<?php if($option->login_protect_time == '5'):?> selected<?php endif?>>5분</option>
							<option value="10"<?php if($option->login_protect_time == '10'):?> selected<?php endif?>>10분</option>
							<option value="15"<?php if($option->login_protect_time == '15'):?> selected<?php endif?>>15분</option>
							<option value="20"<?php if($option->login_protect_time == '20'):?> selected<?php endif?>>20분</option>
							<option value="30"<?php if($option->login_protect_time == '30'):?> selected<?php endif?>>30분</option>
							<option value="40"<?php if($option->login_protect_time == '40'):?> selected<?php endif?>>40분</option>
							<option value="50"<?php if($option->login_protect_time == '50'):?> selected<?php endif?>>50분</option>
							<option value="60"<?php if($option->login_protect_time == '60'):?> selected<?php endif?>>60분</option>
						</select>
						동안
						<select id="cosmosfarm_members_login_protect_count" name="cosmosfarm_members_login_protect_count">
							<option value="1"<?php if($option->login_protect_count == '1'):?> selected<?php endif?>>1회</option>
							<option value="2"<?php if($option->login_protect_count == '2'):?> selected<?php endif?>>2회</option>
							<option value="3"<?php if($option->login_protect_count == '3'):?> selected<?php endif?>>3회</option>
							<option value="4"<?php if($option->login_protect_count == '4'):?> selected<?php endif?>>4회</option>
							<option value="5"<?php if($option->login_protect_count == '5'):?> selected<?php endif?>>5회</option>
							<option value="6"<?php if($option->login_protect_count == '6'):?> selected<?php endif?>>6회</option>
							<option value="7"<?php if($option->login_protect_count == '7'):?> selected<?php endif?>>7회</option>
							<option value="8"<?php if($option->login_protect_count == '8'):?> selected<?php endif?>>8회</option>
							<option value="9"<?php if($option->login_protect_count == '9'):?> selected<?php endif?>>9회</option>
							<option value="10"<?php if($option->login_protect_count == '10'):?> selected<?php endif?>>10회</option>
						</select>
						틀릴 경우
						<select id="cosmosfarm_members_login_protect_lockdown" name="cosmosfarm_members_login_protect_lockdown">
							<option value="1"<?php if($option->login_protect_lockdown == '1'):?> selected<?php endif?>>1분</option>
							<option value="2"<?php if($option->login_protect_lockdown == '2'):?> selected<?php endif?>>2분</option>
							<option value="3"<?php if($option->login_protect_lockdown == '3'):?> selected<?php endif?>>3분</option>
							<option value="4"<?php if($option->login_protect_lockdown == '4'):?> selected<?php endif?>>4분</option>
							<option value="5"<?php if($option->login_protect_lockdown == '5'):?> selected<?php endif?>>5분</option>
							<option value="10"<?php if($option->login_protect_lockdown == '10'):?> selected<?php endif?>>10분</option>
							<option value="15"<?php if($option->login_protect_lockdown == '15'):?> selected<?php endif?>>15분</option>
							<option value="20"<?php if($option->login_protect_lockdown == '20'):?> selected<?php endif?>>20분</option>
							<option value="30"<?php if($option->login_protect_lockdown == '30'):?> selected<?php endif?>>30분</option>
							<option value="40"<?php if($option->login_protect_lockdown == '40'):?> selected<?php endif?>>40분</option>
							<option value="50"<?php if($option->login_protect_lockdown == '50'):?> selected<?php endif?>>50분</option>
							<option value="60"<?php if($option->login_protect_lockdown == '60'):?> selected<?php endif?>>60분</option>
						</select>
						동안 로그인 시도를 제한합니다.
						<?php else:?>
						※ 로그인 기록 저장을 사용해주세요.
						<?php endif?>
						<p class="description">무차별 대입 공격(Brute Force Attack)을 차단하기 위해서 비밀번호를 연속해서 잘못 입력하면 잠시동안 로그인을 차단합니다.</p>
						<p class="description">관리자 계정도 예외 없이 차단됩니다.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_members_use_login_timeout">자동 로그아웃</label></th>
					<td>
						<select id="cosmosfarm_members_use_login_timeout" name="cosmosfarm_members_use_login_timeout">
							<option value="">사용중지</option>
							<option value="1"<?php if($option->use_login_timeout == '1'):?> selected<?php endif?>>자동 로그아웃 후 로그인 페이지로 이동</option>
							<option value="2"<?php if($option->use_login_timeout == '2'):?> selected<?php endif?>>자동 로그아웃 후 원래 있던 페이지로 되돌아오기</option>
						</select>
						<br>
						<select id="cosmosfarm_members_login_timeout" name="cosmosfarm_members_login_timeout">
							<option value="1"<?php if($option->login_timeout == '1'):?> selected<?php endif?>>1분</option>
							<option value="2"<?php if($option->login_timeout == '2'):?> selected<?php endif?>>2분</option>
							<option value="3"<?php if($option->login_timeout == '3'):?> selected<?php endif?>>3분</option>
							<option value="4"<?php if($option->login_timeout == '4'):?> selected<?php endif?>>4분</option>
							<option value="5"<?php if($option->login_timeout == '5'):?> selected<?php endif?>>5분</option>
							<option value="10"<?php if($option->login_timeout == '10'):?> selected<?php endif?>>10분</option>
							<option value="15"<?php if($option->login_timeout == '15'):?> selected<?php endif?>>15분</option>
							<option value="20"<?php if($option->login_timeout == '20'):?> selected<?php endif?>>20분</option>
							<option value="30"<?php if($option->login_timeout == '30'):?> selected<?php endif?>>30분</option>
							<option value="40"<?php if($option->login_timeout == '40'):?> selected<?php endif?>>40분</option>
							<option value="50"<?php if($option->login_timeout == '50'):?> selected<?php endif?>>50분</option>
							<option value="60"<?php if($option->login_timeout == '60'):?> selected<?php endif?>>60분</option>
						</select>
						동안 페이지 이동이 없으면 자동으로 로그아웃을 합니다.
						<p class="description">사용자의 활동이 없을 경우 개인정보 보호를 위해서 자동으로 로그아웃을 합니다.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_members_save_activity_history">개인정보 활동 기록 저장</label></th>
					<td>
						<select id="cosmosfarm_members_save_activity_history" name="cosmosfarm_members_save_activity_history">
							<option value="">사용중지</option>
							<option value="1"<?php if($option->save_activity_history):?> selected<?php endif?>>사용</option>
						</select>
						<p class="description">본인 또는 관리자가 회원정보를 조회하거나 업데이트한 시간, IP주소 등 정보를 저장합니다.</p>
					</td>
				</tr>
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