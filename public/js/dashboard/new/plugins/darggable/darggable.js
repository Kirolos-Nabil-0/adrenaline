$(function () {
	var order = [];
	$(".sortable").sortable({
		connectWith: '.sortable',
		items: '.card-draggable',
		revert: true,
		animation: 150,
		placeholder: 'card-draggable-placeholder',
		forcePlaceholderSize: true,
		opacity: 0.77,
		cursor: 'move',
		stop: function (event, ui) {
			order = []
			var items = document.querySelectorAll(".card-draggable");
			items.forEach(item => {
				order.push($(item).data('id'));
			})
			$.ajax({
				type: "get",
				url: site_url + `/admin/orderLesons`,
				data: {
					lessons: order,
				},
			}).done(function () {
				console.log("order done")
			});
		}
	});
});

