<?php 

$date = '';
$metaquery =  array();
$taxquery =  array();


// Filter queries
if(isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date'])) {
	$date = date('Y-m-d', strtotime($_REQUEST['start_date']));
	$metaquery = array (
		'relation' => 'AND',
		array(
			'key'        => 'start_date',
			'compare'    => '==',
			'value'      => $date,
			),
	);
}
if(isset($_REQUEST['category']) && !empty($_REQUEST['category'])) { 
	$taxquery =  array(
		array(
		'taxonomy' => 'event_types',
		'terms' => $_REQUEST['category'],
		'field' => 'slug',
		'operator'  => 'IN'
        )
	);
}

$taxonomies = get_terms( array(
    'taxonomy' => 'event_types',
    'hide_empty' => false
) );
?>

<!-- Filter Section -->
<div class="alignwide event-filter">
	<div class="filter-inner">
	
		<h3>Filter By </h3>
		
		<form action="" method="get" name="filter-event">
			<div class="filter-field">
				<label> Start Date : </label>
				<input type="date" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date']; ?>" onchange="this.form.submit()" />
			</div>
			
			<?php if ( $taxonomies ) { ?>
			<div class="filter-field">
				<label> Category : </label>
				<select name="category" id="category-filter" onchange="this.form.submit()">
				<option value=''>-Select-</option>
				<?php 
				foreach ( $taxonomies as $taxonomy ) {
					$selected = '';
					if(isset($_REQUEST['category']) && $taxonomy->slug == $_REQUEST['category'] ) {
						$selected = 'selected';
					}
					echo '<option value="'.$taxonomy->slug.'" '.$selected.'>' . $taxonomy->name . '</option>';
				} ?>
				</select>
			</div>
			<?php } ?>
			
		</form>
	</div>
</div>


<!-- Event list section -->
<div class="eventlist-wrapper">
	<?php
	$args  = array( 
		'post_type' => 'events', 
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'order' => 'DESC',
		'meta_query' => $metaquery,
		'tax_query'=> $taxquery,
	);
		  
				
	$events = new WP_Query( $args );
	
	if (!empty($events) && $events->have_posts()) { 
		while ( $events->have_posts() ) { $events->the_post();
		?>
		<article  id="post-<?php echo get_the_ID(); ?>">

		<div class="post-inner thin">

				<div class="entry-content">

					<h5 class="entry-title"><?php echo get_the_title(); ?></h5>
					
					<?php
					$categories =  get_the_terms( get_the_ID(), 'event_types' );
					$cats = array();
					if (!empty($categories)) {
						foreach ( $categories as $category ) {
							$cats[] = $category->name;
						}
					}
					?>
					
					<?php
					$start_date = get_post_meta( get_the_ID(), 'start_date', true );
					$formatdate = date('F j, Y', strtotime($start_date));
					
					$end_date = get_post_meta( get_the_ID(), 'end_date', true );
					$formatenddate = date('F j, Y', strtotime($end_date));
					
					$location = get_post_meta( get_the_ID(), 'location', true ); 
					
					?>
					
					<div class="entry-categories-inner">
					
						<span>Category :</span>				
						<?php echo implode(",",$cats); ?><br/>
						
						<span>Start Date :</span>
						<?php echo $formatdate; ?><br/>
						
						<span>End Date :</span>
						<?php echo $formatenddate; ?>
						<br/>
						
						<span>Location :</span>
						<?php echo $location; ?>
						
					</div>
					
					<div class="section-inner medium">
						<?php the_post_thumbnail(); ?>
					</div>
					
					<div class="section-inner max-percentage">
						<?php the_excerpt(); ?>
					</div>
					
					
				</div>
			</div>
		</article>
		<?php 
		}
		
	} else { ?>
		
		<h5 class="entry-title">
			No Result Found!
		</h5>
		
	<?php 
		}
	?>
</div>
