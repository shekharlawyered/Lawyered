<style>

#detail-head{
	background: #edd460;
	color: #fff;
	font-weight: bold;
	padding: 1.6rem;
}

#proceeding{
	background: #eee;
	padding: 1.6rem;
}
</style>

<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if ($title_prefix || $title_suffix || $display_submitted || !$page): ?>
  <header>
    <?php print render($title_prefix); ?>
    <?php if (!$page): ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>

    <?php if ($display_submitted): ?>
      <div class="submitted">
        <?php print $user_picture; ?>
        <span class="glyphicon glyphicon-calendar"></span> <?php print $submitted; ?>
      </div>
    <?php endif; ?>
  </header>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['field_tags']);
      dsm($content);
      ?>
      <div class="container-fluid" id="detail-head">
      	<div class="row">
      		<div class="col-md-4">
      			#<?php print render($content['field_case_number'][0]['#markup']);?>
      		</div>
      		<div class="col-md-4">
      			<?php print render($content['field_court'][0]['#title']);?>
      		</div>
      		<div class="col-md-4">
      			<?php print render($content['field_reatined_for'][0]['#title']);?>
      		</div>
      	</div>
      </div>
      
      <div class="container-fluid" id="proceedings">
      	<div class="row">
      		<?php
			$my_view_name = 'proceeding';
			$my_display_name = 'page';
			$my_view = views_get_view($my_view_name);
			if ( is_object($my_view) ) {
			  $my_view->set_display($my_display_name);
			  $my_view->pre_execute();
			  print $my_view->render($my_display_name);
			}
			?>
      	</div>
      </div>
      <?php 
      	print render($content);
      ?>
  </div>

  <?php if (!empty($content['field_tags']) || !empty($content['links'])): ?>
    <footer>
    <?php print render($content['field_tags']); ?>
    <?php print render($content['links']); ?>
    </footer>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

</article>