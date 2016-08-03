<?php include 'view/home/public/header.php'; ?>
<?php include 'view/home/home/lists.php'; ?>
<script src='public/home/js/message.js' type='text/javascript'></script>
<style type='text/css'>
	.board-form {
		margin: 15px auto;
		border: 1px solid #f1f4f7;
		width : 70%;
		min-width: 1020px;
	}
	.board-form p {
		margin: 0px;
		text-align: center;
		background-color: #f1f4f7;
		color: #666;
		line-height: 32px;
		font-size: 18px;
	}
</style>
<div class='board-form'>
	<p>文明社会，从理性发帖开始。谢绝低于攻击和人身攻击！谢谢！</p>
	<form id = "form" method='post' action=''>
		<div>
			<input name = 'name' id = 'name' type ='text' class = 'required input-text'  placeholder = '您的名称' />
		</div>
		<div>
			<textarea name = "content" rows = "5" clos = "80" class='required' id='content'  placeholder="您想对我说点啥？可以畅享语言！"></textarea>
		</div>
		<div>
			<button type = 'submit' id='submit'  name = 'submit' class = 'input-submit'/>马上留言</button>
		</div>
	</form>
</div>
<?php include 'view/home/public/footer.php'; ?>
