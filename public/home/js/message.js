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

		if($(this).is('#content')) {
			if(this.value == '' || this.value.length < 5) {
				var errorMsg = '内容这么短？至少来个5个字啊！！';
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
