<?php include 'view/admin/public/header.php'; ?>
<?php include 'view/admin/public/left.php'; ?>
<style type='text/css'>
	.admin-contents table {
		text-align: center;
		line-height: 30px;
		width: 99%;
		font-size: 24px;
		margin: 2px;
		border-collapse: collapse;
	}
	.admin-contents tr {
		border: 1px solid #ddd;
	}
	.admin-contents td {
		padding: 3px 0 3px 0;
	}
	.admin-contents a {
		text-decoration: none;
	}
	.th-id {
		min-width: 100px;
	}
	.th-name {
		min-width: 200px;
	}
	.th-content {
		min-width: 300px;
	}
	.th-time {
		min-width: 300px;
	}
	.th-operation {
		min-width: 150px;
	}
</style>
<div class='admin-contents'>
<?php include 'view/admin/public/page.php'; ?>
	<div>
		<table>
			<tbody>
				<tr>
					<th class='th-id'>ID</th>
					<th class='th-name'>留言者</th>
					<th class='th-content'>内容</th>
					<th class='th-time'>留言时间</th>
					<th class='th-operation'>操作</th>
				</tr>
				<?php
					$editUrl = 'index.php?app=admin&controller=home&action=edit&id=';

					foreach($lists as $list) {
						echo "<tr><td>".$list['id']."</td><td>".$list['name']."</td><td title='".$list['content']."'>".mb_substr($list['content'], 0, 40, 'utf-8')."</td><td>".date('Y-m-d H:i:s', $list['addtime'])."<td><a href='".$editUrl.$list['id']."'>编辑</a> <a data-id = '".$list['id']."' href='javascript:;' class='msg-del' >删除</a></td></tr>";
					}
				?>
			</tbody>
		</table>
		<span><span>
	</div>
<?php include 'view/admin/public/page.php'; ?>
</div>
<script>
	$(function() {
		$('.msg-del').click(function() {
			if(confirm("确定要删除这条留言？？")) {
				var id = $(this).data('id');
				var url = 'index.php?app=admin&controller=home&action=delete&id='+id;
				$.ajax({
					type: 'post',
					url: url,
					data: {'id': id},
					success: function(msg){
						location.reload();
					}
				});
			}
		});
	});
</script>
<?php include 'view/admin/public/footer.php'; ?>
