<?php get_header(); ?> 
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
            	<?php $designer = get_the_title(); ?>	
           <?php endwhile; ?>
           <?php else : ?>
           <?php endif; ?> 
           
            <div id="main" >
			<div class="side spacer">
           <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
	              
	                	<?php if ( has_post_thumbnail() ) : ?>
		                    	<?php 
		                    	$imgsrcparam = array(
								'alt'	=> trim(strip_tags( $post->post_excerpt )),
								'title'	=> trim(strip_tags( $post->post_title )),
								);
		                    	$thumbID = get_the_post_thumbnail( $post->ID, 'portrait', $imgsrcparam ); ?>
		                        <div class="preview"><a href="<?php the_permalink() ?>"><?php echo "$thumbID"; ?></a></div>
		                    <?php else :?>
		                        <div class="preview">
		                        	<a href="<?php the_permalink() ?>"><img src="<?php bloginfo('template_url'); ?>/images/default-thumbnail.jpg" alt="<?php the_title(); ?>" /></a>
		                        </div>
		                    <?php endif; ?>
		                    <div class="info">
		                    	<h1><?php the_title(); ?></h1>
		                    	<?php the_content(); ?>
	                	 
	                	  
	                	  <div class="socials">
	                	   	<?php foreach(get_field( 'socials' ) as $social): ?>
	                     		<?php $icon = $social['social']; ?>
	                     		
	                     		<a href="<?php echo $social['url']; ?>" ><img class="social" src="<?php echo check_socials( $icon ); ?>" /></a>                     
	                    	 <?php endforeach; ?>
	                     </div>
		                 </div>
		   	<?php endwhile; ?>
            <?php else : ?>
                <h1><?php _e("Sorry, but you are looking for something that isn&#8217;t here."); ?></h1>
                
            <?php endif; ?> 
	        </div>        
            <?php $args = array(
				'post_type' => 'project',
				'post_status' => 'private',
				'posts_per_page' => -1);
				
				
				query_posts( $args );
				while(have_posts()) : the_post(); ?>
				<?php while(the_repeater_field('designers')): ?>
					 <?php if( $designer == get_sub_field('designer') ): ?>
		               	 <div class="article spacer border">
		                	<h1><?php the_title(); ?></h1>
		                    <h2 class="role"><?php the_sub_field('role') ?></h2>
		                    <div class="hrtitle"></div>
		                    <h2 class="period"><?php the_field( 'period' ); ?></h2>
		                    
		                     
		                     <?php if( get_field( 'clients' ) ): ?>
		                     <h4 class="subtitle">Clients:</h4>
		                     	<div class="hrclients"></div>
			                     <div class="clients">
				                     <?php foreach(get_field( 'clients' ) as $client): ?>
				                     		<a href="<?php echo($client["site"]);?>"><?php echo($client["client"]);?></a>
				                     		
				                     <?php endforeach; ?>
				                 </div>
				                 <div class="hrclients white"></div>
		                     <?php endif; ?>
		                     
		                    <?php the_content(); ?>
		                    
		                     <?php if( get_field( 'galleries' ) ): ?>
			                     <?php foreach(get_field( 'galleries' ) as $gallery): ?>
			                     	<?php $url = $gallery["url"]; ?>
			                     	<div class="gallery"><?php echo do_shortcode('[nivoslider slug="'.$url.'"]'); ?></div>
			                     <?php endforeach; ?>
		                     <?php endif; ?>
		                     
		                     <?php if( get_field( 'videos' ) ): ?>
			                     <?php foreach(get_field( 'videos' ) as $video): ?>
			                     	<?php $url = $gallery["url"]; ?>
			                     	<div class="video">
			                     		<iframe src="http://player.vimeo.com/video/<?php echo $url ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ff0179" width="580" height="326" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
			                     		</iframe>
			                     	</div>
			                     <?php endforeach; ?>
		                     <?php endif; ?>
		                </div>
	                <?php endif; ?>
          		 <?php endwhile; ?>
          		
                
           <?php endwhile; ?>
          
           <?php wp_reset_query(); ?>
             
         
            </div>
<?php get_footer(); ?>