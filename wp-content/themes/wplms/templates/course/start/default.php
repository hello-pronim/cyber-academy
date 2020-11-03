<?php

// COURSE STATUS : 
// 0 : NOT STARTED 
// 1: STARTED 
// 2 : SUBMITTED
// > 2 : EVALUATED

// VERSION 1.8.4 NEW COURSE STATUSES
// 1 : START COURSE
// 2 : CONTINUE COURSE
// 3 : FINISH COURSE : COURSE UNDER EVALUATION
// 4 : COURSE EVALUATED


if ( ! defined( 'ABSPATH' ) ) exit;

do_action('wplms_before_start_course');

get_header( vibe_get_header() ); 
/**
* wplms_before_course_main_content hook.
*
* @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
* @hooked woocommerce_breadcrumb - 20
*/
do_action('wplms_before_course_main_content');

?>
<section id="content">
    <div class="<?php echo vibe_get_container(); ?>">
        <div class="row">
				<div class="col-md-12">
					<a class="mink-back" onclick="goBack()">Back</a>				
					
				</div>
			</div>
		
		<div class="row">
		
			
		
            <div class="col-md-9">
                
				<div class="Question-block" id="MyQQ<?php echo get_the_ID(); ?>">
				
					<div class="unit_content">
						<h3>Do you have any skills about this topic ?</h3>
						<div class="radiooOptions">
							<div class="radio">
							  <input id="sex-male" type="radio" name="topic" value="yes" />
							  <label for="sex-male">Yes</label>
							</div>

							<div class="radio">
							  <input id="sex-female" type="radio" name="topic" value="no" />
							  <label for="sex-female">No</label>
							</div>

													
						</div>						
					</div>
				
				</div>
				
				<script>
					
				
					jQuery("#mink-reset").on("click", function(){
					 sessionStorage.removeItem('keya');
					 window.location.reload();
					});
					/*
					if (sessionStorage.getItem('myss') !== 'true'){
						
						// if the storage item 'se-pre-con', does not exist, run the code in curly braces
						document.getElementById("MyQQ<?php echo get_the_ID(); ?>").style.display = 'block';
						
						console.log('session Not');
						}

					else {
						document.getElementById('MyQQ<?php echo get_the_ID(); ?>').style.display="none";
						//document.getElementById("sminku").style.display = "block";
						console.log('session created');
						//sessionStorage.removeItem('not_reloaded');
						
						
					}
					*/
					
					if (sessionStorage.getItem('keya') !== 'value'){
					
				    document.getElementById('MyQQ<?php echo get_the_ID(); ?>').style.display="block";	
					console.log('Notset');
					
					
					jQuery(function () {
						 jQuery('#sminku').hide();
					 });
					
						
					}else{
					document.getElementById('MyQQ<?php echo get_the_ID(); ?>').style.display="none";	
					//document.getElementById('sminku').style.display="block";
					jQuery("#sminku").addClass("jjjjj");
					console.log('set');
					
					
					
					
					
					}
					
					
					
					
					jQuery('.radiooOptions input').on('change', function() {
					   //alert(jQuery('input[name=topic]:checked').val()); 
					   
					   var topic = jQuery('input[name=topic]:checked').val(); 
					   
					    if(topic == 'yes'){
						
						jQuery('.Question-block').hide(100);
						jQuery('#sminku').show(100);
						
						//jQuery('.course_timeline').show(100);
						//jQuery('.progress.course_progressbar').show(100);

						//sessionStorage.setItem('myss','true'); 
						sessionStorage.setItem("keya", "value");
						 
					   
						}else{
						
						//window.history.back();
						jQuery('.Question-block').hide(100);
						jQuery('#sminku').show(100);
						
						//jQuery('.course_timeline').show(100);	
						//jQuery('.progress.course_progressbar').show(100);						
						//sessionStorage.setItem('myss','true'); 	
						sessionStorage.setItem("keya", "value");
						}
					   
					}); 
				</script>		
				<div id="sminku" class="unit_wrap <?php echo vibe_sanitizer($class,'text'); ?>">
            
                    <?php

                        if ( have_posts() ) : while ( have_posts() ) : the_post();
                        /**
                        * wplms_unit_content hook.
                        *
                        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                        * @hooked woocommerce_breadcrumb - 20
                        */
                        do_action('wplms_unit_content');
                        endwhile;
                        endif;
                        
                        /**
                        * wplms_unit_controls hook.
                        *
                        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                        * @hooked woocommerce_breadcrumb - 20
                        */
                        do_action('wplms_unit_controls');
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php 
                    /**
                    * wplms_course_action_points hook.
                    *
                    * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                    * @hooked woocommerce_breadcrumb - 20
                    */
                    do_action('wplms_course_action_points');
                ?>
            </div>
        </div>
    </div>
</section>
<?php

do_action('wplms_after_start_course');

get_footer( vibe_get_footer() );  