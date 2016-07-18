<?php include 'view/home/public/header.php'; ?>
<?php include 'view/home/home/lists.php'; ?>
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
			<textarea name = "content" rows = "5" clos = "80" >您想对我说点啥？可以畅享语言！</textarea>
		</div>
		<div>
			<button type = 'submit' id='submit'  name = 'submit' class = 'input-submit'/>马上留言</button>
		</div>
	</form>
</div>
<?php include 'view/home/public/footer.php'; ?>
<script type='text/javascript'>
$(function() {
	$('form .required').each(function() {
		var required = $('<strong class="high">* </strong>');
		$(this).parent().append(required);
	});
	$('form :input').blur(function() {
		var parent = $(this).parent();
		parent.find(".formtips").remove();

		if($(this).is('#name')) {
			if(this.value == '' || this.value.length < 2) {
				var errorMsg = '您的名字这么短？至少来个2个字啊！！';
				parent.append('<span class="formtips onError high">'+errorMsg+'</span>');
			}
		}
	}).keyup(function() {
		$(this).triggerHandler('blur');
	}).focus(function() {
		$(this).triggerHandler('blur');
	});
	// 表单验证
	$('#submit').click(function(){
		$('form .required').trigger('blur');
		var numError = $('form .onError').length;
		if(numError) {
			return false;
		}
	});
});
</script>
