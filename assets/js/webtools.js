$(document).ready(function() {

	tinymce.init({
		selector: ".fulltext-editor",
		menubar: false,
		plugins: [
		     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		     "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		     "table contextmenu directionality emoticons paste textcolor code"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		image_advtab: true ,
		height: 500,

		setup: function(editor) {
			editor.on('change',function() {
				editor.save();
			});
		},
		
		relative_urls:false,
    });

    tinymce.init({
		selector: ".simple-editor",
		menubar: false,
		plugins: [
		     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		     "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		     "table contextmenu directionality emoticons paste textcolor code"
		],
		toolbar1: "undo redo | bold italic underline",
		image_advtab: true ,
		height: 500,

		setup: function(editor) {
			editor.on('change',function() {
				editor.save();
			});
		},
		
		relative_urls:false,
    });

})