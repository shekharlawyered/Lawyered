<style>

#detail-head{
	background: #61a9e3;
	color: #fff;
	font-weight: bold;
	padding: 1.6rem;
	text-align:center;
}

#proceeding{
	background: #eee;
	padding: 1.6rem;
}

#details{
	margin-top: 5%;
}

.date{
	padding: 1.2rem;
	color: #433e3d;
	font-weight: 600;
	margin-bottom: 1%;
}

.entry{
	padding: 1.2rem;
	background: #95b6e3;
	font-weight: 600;
	margin-bottom: 4%;
}

.capitalize{
	text-transform: capitalize !important;
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
      dsm($node);
      dsm($content);
      ?>
      <div class="container-fluid" id="detail-head">
      	<div class="row">
      		<div class="col-md-4">
      			<span class="glyphicon glyphicon-briefcase"></span>
      			#<?php print render($content['field_case_number'][0]['#markup']);?>
      		</div>
      		<div class="col-md-4">
      			<i class="fa fa-university"></i>
      			<?php print render($content['field_court'][0]['#title']);
      			if($node->field_location['und'][0]['lid'] != ""){
					$location = location_load_location($node->field_location['und'][0]['lid']);
					print ", ".$location['province_name'];
				}
      			?>
      		</div>
      		<div class="col-md-4">
      			<i class="fa fa-graduation-cap"></i>
      			<?php print render($content['field_retained_for'][0]['#title']);?>
      		</div>
      	</div>
      </div>
      
      
      <?php 
      $timeline = array();
      if(count($node->field_proceeding['und']) > 0){
      	foreach($node->field_proceeding['und'] as $proceeding){
			$proceeding_node = node_load($proceeding['nid']);
			$date = $proceeding_node->field_date['und'][0]['value'];
			$date = new DateTime($date);
			$key = $date->getTimestamp();
			$timeline[$key] = $proceeding_node;
		}
      }
      
	  if(count($node->field_judgement['und']) > 0){
      	foreach($node->field_judgement['und'] as $judgement){
			$judgement_node = node_load($judgement['nid']);
			$date = $judgement_node->field_date['und'][0]['value'];
			$date = new DateTime($date);
			$key = $date->getTimestamp();
			$timeline[$key] = $judgement_node;
		}
      }
      
      krsort($timeline , SORT_DESC);
      
      if(count($timeline) > 0){
		?>
		<div class="container-fluid" id="details">
			
		<?php 
		$i = 1;
		 foreach($timeline as $key => $item){
		?>
			<div class="row">
				<div class="col-md-offset-5 col-md-2 date badge">
					<i class="fa fa-calendar"></i>
				 	<?php print date('D, d M Y', $key);//$item->field_date['und'][0]['value'];?>
				</div>
			</div>
			
			<div class="row">
				<div class="panel panel-default entry">
					<div class="panel-heading trigger-collapse capitalize"><?php print $item->title;?></div>
					<div class="collapsible entry-detail panel-body">
						
					</div>
						
				
				</div>
			</div>
				
		<?php 	
		$i++;
		 }
		 ?>
		 </div>
	<?php 
       }
    ?>
    
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

<script>
	$(document).on('ready',function(){
		$('.trigger-collapsible').on('click',function(){
			$(this).closest('.collapsible').collapse();
		});
	});
</script>