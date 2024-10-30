<?php include 'functions.php';
/*
Plugin Name: Cheapveilingen - Productveilingen
Plugin URI: http://www.cheapveilingen.nl
Description: Toon de goedkoopste veilingen vanaf 1 euro
Author: Cheapveilingen
Version: 1.0
Author URI: http://www.cheapveilingen.nl
*/




  wp_register_sidebar_widget(
    'cheapveil_widget',          // your unique widget id
    'Cheapveilingen',                 // widget name
    'cheapveil_widget_display',  // callback function to display widget
    array(                      // options
        'description' => 'Cheapveilingen Wat Bied Jij?'
    )
);

wp_register_widget_control(
	'cheapveil_widget',		// id
	'cheapveil_widget',		// name
	'cheapveil_widget_control'	// callback function
);



    function cheapveil_widget_control($args=array(), $params=array()) {
    	//the form is submitted, save into database
    	if (isset($_POST['submitted'])) {
    		update_option('cheap_veil_title',$_POST['coupontitle']);
    		
    	}

    	//load options
    	$cheap_veil_title = get_option('cheap_veil_title');
		
    	?>
    	
    	
    	Widget Title<br />
    	<input type="text" class="widefat" name="coupontitle" value="<?php echo $cheap_veil_title; ?>" placeholder="Your title" />
    	<br /><br />
    	<input type="hidden" name="submitted" value="1" />
    	<?php
    }



    function cheapveil_widget_display($args=array(), $params=array()) { 
    	//load options
    	$coupon_title = (get_option('cheap_veil_title')=='' ? 'Coupons' : get_option('cheap_veil_title'));
    	//widget output
    	echo stripslashes($args['before_widget']);
		echo '<h3 class="widget-title">'.$coupon_title."</h3>";
    	echo stripslashes($args['after_title']);
   		$feedUrl = 'http://www.cheapveilingen.nl/rss';
   		$rawFeed = file_get_contents($feedUrl);
  		$xml = new SimpleXmlElement($rawFeed);
   	echo '<ul style="width:400px;  " id="ac">';
   
 foreach ($xml->channel->item as $item) {?>
<li><a target="_blank" href="<?php echo $item->link;?>" style=" font-size:12px; list-style: none; color:white;">
	<?php echo $item->title;?> 
	</a> <BR>

</li>

<?php  }	?>





</ul>
<?php 
   echo stripslashes($args['after_widget']);
 }

