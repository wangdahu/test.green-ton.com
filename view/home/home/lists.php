<style type = 'text/css'>
	.list-main {
		text-align: center;
		width: 70%;
		margin: 0 auto;
		min-width: 1020px;
		border: 1px solid #c9e6f2;
	}
	.list-title-bar {
		font-size: 20px;
		padding: 10px; 
		text-align: left;
		background: #f2f9fc;
	}
	.list {
		padding: 10px;
		font-size: 14px;
		border-bottom: 1px dotted #afafb0;
	}
	.list-left {
		padding-left: 10px;
		float: left;
	}
	.list-right {
		float: right;
		color: gray;
	}
	.list-content {
		clear: both;
		text-align: left;
		padding: 15px 0px 15px;
		margin-left: 2em;
	}
</style>
<?php include 'view/home/public/page.php'; ?>
<div class = 'list-main'>
	<div class = 'list-title-bar'>
		<strong>热门评论</strong>
	</div>
	<?php foreach($lists as $list) { ?>
	<div class = 'list'>
		<div>
			<span class='list-left'>
				<?php echo $list['name'] ?>
			</span>
			<span class='list-right'>
				<?php echo date('Y-m-d H:i:s', $list['addtime']);?>发表说
			</span>
		</div>
		<div class="list-content">
			<?php echo $list['content']; ?>
		</div>
	</div>
	<?php }?>
</div>
<?php include 'view/home/public/page.php'; ?>
<script type='text/javascript' src='public/home/js/page.js'></script>
