<?php include 'view/admin/public/header.php'; ?>
<style type='text/css'>
	.admin-login {
		margin: 100px auto;
		font-size: 30px;
		text-align: center;
	}
	.login-input {
		margin: 10px;
	}
	.logn-input span {
		color: #333;
	}
	.login-input input {
		line-height: 30px;
		width: 300px;
		font-size: 22px;
		color: gray;
		margin-bottom: 10px;
		padding-left: 2px;
		vertical-align: middle;
	}
	.login-button {
		text-decoration: none;
		display: block;
		line-height: 30px;
		text-align: center;
		margin: 0 auto;
		margin-top: 30px;
		width: 100px;
		background-color: #ab2b2b;
		border: 1px solid #ab2b2b;
		color: #fff;
		padding: 10px;
		font-size: 26px;
		border-radius: 3px;
		margin-right: 35px;
	}
</style>
<div class='admin-login'>
	<div style='width: 500px; margin:0 auto; padding-top: 30px; padding-bottom: 30px;text-align: center;'>
		<form method='post'>
			<div class="login-input">
				<span>用户名：</span><input name = 'username' type="text" placeholder='用户名'/>
			</div>
			<div class="login-input">
				<span>密　码：</span><input name = 'password' type='password' placeholder='管理员密码' />
			</div>
			<div>
				<a id="loginBtn" href="javascript:;" hidefocus='true' class='login-button'><span>登 录</span></a>
			</div>
		</form>
	</div>
</div>
<?php include 'view/admin/public/footer.php'; ?>
