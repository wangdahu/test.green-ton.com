<?php include 'view/admin/public/header.php'; ?>
<?php include 'view/admin/public/left.php'; ?>
<style type='text/css'>
	.keyword-list {
		margin: 15px;
	}
	.keyword-tag {
		display: inline-block;
		line-height: 30px;
		font-size: 20px;
		background-color: #e54020;
		color: white;
		margin: 10px;
		padding: 10px;
	}
	.img-del {
		width: 16px;
		height: 16px;
		right: 0px;
		top: 0px;
		float: right;
		margin: -10px;
		cursor: pointer;
	}
</style>
<div class='admin-contents'>
	<div class='keyword-list'>
		<input name='keyword' class='input-text' placeholder='添加关键字，以逗号分隔' /><input type='submit' class='text-submit' id='add-submit' value='添加关键字' /><input type='button' class='text-submit' value='删除关键字' id='del-submit' />
	</div>
	<div class='keyword-list'>
	<?php
		foreach($keywords as $keyword) {
			echo "<span class='keyword-tag' data-id='".$keyword['id']."'>".$keyword['keyword']."</span>";
		}
	?>
	</div>
</div>
<script>
	$(function() {
		$('#add-submit').click(function() {
			var keywords = $("[name='keyword']").val();
			$.ajax({
				type: 'post',
				url: 'index.php?app=admin&controller=keywords&action=add',
				data: {keywords: keywords},
				success: function(msg) {
					layer.msg('添加成功！');
					location.reload();
				}
			});
		});
		$('#del-submit').click(function() {
			var imgStr = "<img class='img-del' src='public/img/x_alt.png'  />";
			if($(this).val() == '取消删除') {
				$('.img-del').remove();
				$(this).val('删除关键字');
			}else{
				$(this).val('取消删除');
				$('.keyword-tag').each(function() {
					var value = $(this).html()+imgStr;
					$(this).html(value);
				});
			}	
		});


		$(document).on("click",".img-del", function(){
			var parent = $(this).parent(),
			id = parent.data('id');
			$.ajax({
				type: 'post',
				url: 'index.php?app=admin&controller=keywords&action=delete',
				data: {id: id},
				success: function(msg) {
					parent.remove();
					layer.msg('删除成功！');
				}
			});
			
		});
	});
</script>
<?php include 'view/admin/public/footer.php'; ?>
