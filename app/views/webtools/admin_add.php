<div class="col-xs-12">
		<div class="box box-danger">
            <!--
            <div class="box-header with-border">
              <h3 class="box-title">Add new admin</h3>
            </div>
            -->
            <form role="form" method="POST" action="<?php echo site_url('webtools/admin/addprocess'); ?>">
              	<div class="box-body">

              		<?php if($error!=''): ?>
              		<div class="alert alert-warning alert-dismissible">
		               	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
		                <?php echo $error_msg; ?>
		           	  </div>
		           	  <?php endif; ?>

                  <div class="form-group">
                    <label for="group">Group</label>
                    <select class="form-control" name="group">
                      <?php foreach ($group as $v): ?>
                      <option value="<?php echo $v->id ?>"><?php echo $v->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username">
                  </div>

                  <div class="form-group">
                    <label for="username">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                  </div>
             	  
                </div>
              	<div class="box-footer">
                	<button class="btn btn-danger" type="submit">Add</button>
              	</div>
            </form>
          </div>
</div>