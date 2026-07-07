<div class="col-xs-12">
  <div class="box box-danger">
    <div class="box-body">

                  <?php if($error=='error'): ?>
                  <div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    <?php echo $error_msg; ?>
                  </div>
                  <?php elseif($error=='success'): ?>
                  <div class="alert alert-success alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo $success_msg; ?>
                  </div>
                  <?php endif; ?>

        <table class="datatable table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>Username</th>
            <th>Group</th>
            <th width="120px">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          
          <?php foreach($list as $k => $v): ?>
            <tr>
              <td><?php echo $v->username; ?></td>
              <td><?php echo $v->name; ?></td>
              <td>
                <div class="btn-group pull-right">
                  <a class="btn btn-sm btn-default" href="<?php echo site_url('webtools/admin/edit/'.$v->id); ?>" title="edit"><i class="fa fa-edit"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo site_url('webtools/admin/delete/'.$v->id); ?>" title="delete"><i class="fa fa-trash"></i> Delete</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>
</div>