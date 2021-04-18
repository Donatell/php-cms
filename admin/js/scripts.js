ClassicEditor
	.create(document.querySelector('#editor'))
	.catch(error => {
		console.error(error);
	});

$(document).ready(function () {
	$('#selectAllBoxes').click(function (e) {
		if (this.checked) {
			$('.checkbox').each(function () {
				this.checked = true;
			});
		} else {
			$('.checkbox').each(function () {
				this.checked = false;
			});
		}
	});
});