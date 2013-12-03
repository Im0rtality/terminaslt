$(function(){
	function escapeHtml(string) {
		var entityMap = {
			"&": "&amp;",
			"<": "&lt;",
			">": "&gt;",
			'"': '&quot;',
			"'": '&#39;',
			"/": '&#x2F;'
		};
		return String(string).replace(/[&<>"'\/]/g, function (s) {
			return entityMap[s];
		});
	}
	$('.typeahead').typeahead({
		source: function(query, process){
			return $.getJSON(
				$('.typeahead').data('link') + query,
				{},
				function (data) {
					return process(data);
				});
		}
	});
	$('#term-search-form').submit(function(){
		//$(this).attr('action', 'term/view/' + $('#term-search-form-query').val());
		$('input[name="action"]').val('view/' + $('#term-search-form-query').val());
	});
	$('#form-add-comment > div > button[type="submit"]').click(function(e){
		$.post(
			//"index.php?controller=comment&action=add",
			"../../../comment/add",
			$('#form-add-comment').serialize(),
			function(data){
				if (data === 'OK') {
					console.log("AJAX returned OK");
					$("#form-add-comment").hide(500).parent().append("<blockquote><p class='muted'>" + escapeHtml($('#form-add-comment > textarea').val()) + "</p><small>"+$("#user-name").text() + "</small></blockquote>");
				} else {
					console.log("AJAX returned error:", data);
				}
			}
			);
		e.preventDefault();
	});
	$('.btn-action').click(function(){
		var action = $(this).data('action');
		var controller = $(this).data('controller');
		var id = $(this).data('id');
		var tr = $(this).parent().parent();
		switch(action) {
			case 'delete':
			//$.get('index.php?controller=' + controller + '&action=' + action + '/' + id, function(data){
			$.get('../../' + controller + '/' + action + '/' + id, function(data){
				if (data !== 'OK') {
					console.log(controller + '->' + action + '() failed!');
				} else {
					tr.hide(200);
				}
				console.log(data);
			});
			break;
			case 'edit':
			break;
			default:
			console.log("Error: unimplemented action", action, controller, id);
		}
	});
});