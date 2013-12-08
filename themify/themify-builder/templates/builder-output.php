<div id="themify_builder_content-<?php echo $builder_id; ?>" data-postid="<?php echo $builder_id; ?>" class="themify_builder_content themify_builder themify_builder_front">
	<?php foreach ( $builder_output as $rows => $row ): ?>
	<!-- module_row -->
	<div class="themify_builder_row module_row clearfix">

		<?php if ( $this->frontedit_active ): ?>
		<div class="themify_builder_row_top">
			<div class="move_row"></div><!-- /move_row -->
			<div class="row_menu">
				<div class="menu_icon">
				</div>
				<ul class="themify_builder_dropdown">
					<li><a href="#" class="themify_builder_duplicate_row"><?php _e('Duplicate', 'themify') ?></a></li>
					<li><a href="#" class="themify_builder_delete_row"><?php _e('Delete', 'themify') ?></a></li>
				</ul>
			</div>
			<!-- /row_menu -->
			<div class="toggle_row"></div><!-- /toggle_row -->
		</div>
		<!-- /row_top -->

		<div class="themify_builder_row_content">	
		<?php endif; // builder edit active ?>

		<?php foreach ( $row['cols'] as $cols => $col ): ?>
		<div class="<?php echo $col['grid_class']; ?><?php echo ($this->frontedit_active) ? ' themify_builder_col' : ''; ?>">
			<?php if($this->frontedit_active): ?>
			<div class="themify_module_holder">
				<div class="empty_holder_text"><?php _e('drop module here', 'themify') ?></div><!-- /empty module text -->
			<?php endif; ?>
				
				<?php
					if ( isset( $col['modules'] ) && count( $col['modules'] ) > 0 ) { 
						foreach ( $col['modules'] as $modules => $mod ) { 
							$w_wrap = ( $this->frontedit_active ) ? true : false;
							$w_class = ( $this->frontedit_active ) ? 'r'.$rows.'c'.$cols.'m'.$modules : '';
							$identifier = array( $rows, $cols, $modules ); // define module id
							$this->get_template_module( $mod, true, $w_wrap, $w_class, $identifier );
						}
					}
				?>
			
			<?php if ( $this->frontedit_active ): ?>
			</div>
			<!-- /module_holder -->
			<div class="col_dragger ui-resizable-handle ui-resizable-e" title="<?php _e('Drag left/right to change columns','themify') ?>"></div><!-- /col_dragger -->
			<?php endif; ?>
		</div>
		<!-- /col -->
		<?php endforeach; // end col loop ?>

		<?php if ( $this->frontedit_active ): ?>
		</div> <!-- /themify_builder_row_content -->
		<?php endif; ?>

	</div>
	<!-- /module_row -->

	<?php endforeach; // end row loop ?>

	<?php
		if ( $this->frontedit_active ) {
			themify_builder_col_detection();
		}
	?>

</div>
<!-- /themify_builder_content -->