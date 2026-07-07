<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-body">

		<?php $web_res = $this->session->flashdata('web_res'); ?>

		<?php if (!empty($web_res)) { ?>

			<div class="alert alert-<?php echo $web_res['status']; ?> alert-dismissible">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h4><?php echo $web_res['head']; ?></h4>
				<?php echo $web_res['msg']; ?>
			</div>

		<?php } ?>

		    <table id="table-data" class="datatable table table-bordered table-hover table-striped">
		    <thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Desc</th>
					<th>Header Image</th>
					<th>Featured Image</th>
					<th>Created Date</th>
					<th width="120px">&nbsp;</th>
				</tr>
		    </thead>
		    <tbody>

		    </tbody>
		  </table>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 5 ]
        }],
        dom: '<\"datatable-header\"fl><\"datatable-scroll\"t><\"datatable-footer\"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

	$('#table-data').dataTable( {
		'ajax': baseurl+'webtools/articles/get_articles',
        'columns': [
            { 'data': 'article_id' },
            { 'data': 'title' },
            { 'data': 'short_desc' },
            { 'data': 'header_image' },
            { 'data': 'featured_image' },
            { 'data': 'created_date' },
            { 'data': 'action' }
        ]
	});
});
</script>