<?php include 'view/admin/public/header.php'; ?>
<?php include 'view/admin/public/left.php'; ?>
<style type='text/css'>
.edit-form {
	font-size: 24px;
	margin: 10px;
	line-height: 30px;

}
.form-span {
	text-align: right;
	width: 100px;
	margin-right: 10px;
	display: inline-block;
}
</style>
<div class='admin-contents'>
	<form class = "edit-form" id = "form" method='post' action=''>
		<div>
			<span class='form-span'>ID：</span><span><?php echo $message['id']; ?><input type='hidden' id="id" name='id' value="<?php echo $message['id']; ?>"/></span>
		</div>
		<div>
			<span class='form-span'>Name：</span><input name = 'name' value = "<?php echo $message['name']; ?>" id = 'name' type ='text' class = 'required input-text'  placeholder = '您的名称' />
		</div>
		<div>
			<span class='form-span'>Content: </span><textarea name = "content" rows = "5" clos = "80" id="content"  placeholder="您想对我说点啥？可以畅享语言！" class='required input-textarea' ><?php echo $message['content']; ?></textarea>
		</div>
		<div>
			<span class='form-span'>Date: </span><span><?php echo date('Y-m-d H:i:s', $message['addtime']); ?></span>
		</div>
		<div>
			<button type = 'submit' id='submit'  name = 'submit' class = 'input-submit'/>马上编辑</button>
			<button type = 'reset' class = 'input-reset'/>马上重置</button>
		</div>
	</form>
</div>
<script src='public/home/js/message.js' type='text/javascript'></script>
<?php include 'view/admin/public/footer.php'; ?>
