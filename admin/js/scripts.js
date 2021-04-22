ClassicEditor
	.create(document.querySelector('#editor'))
	.catch(error => {
		console.error(error);
	});

const $passwordInput = $('#password-input');

$('#password-checkbox').on('click', function () {
	if ($(this).is(':checked')) {
		$passwordInput.removeClass('hidden');
	} else {
		$passwordInput.addClass('hidden');
	}
});

$(document).ready(function () {

	// "Select All" checkbox behaviour
	$('#selectAllBoxes').on('click', function (e) {
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

	$('.delete_link').on('click', function () {
		const id = this.rel;
		$('#modal_delete_link')
			.attr('href', `posts.php?action=view_posts&delete=${id}`);

		$('#myModal').modal('show');
	});
});