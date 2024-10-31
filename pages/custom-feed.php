<?php
/**
 * Template Name: RSS Feeds Template
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Default value 
$post_per_page= 10;
$post_type= 'post';


//from option value
if(get_option('post_type_to_feed') != ''){
	$post_type = get_option('post_type_to_feed');
}
if(get_option('post_cont_in_feed') != ''){
	$post_per_page = get_option('post_cont_in_feed');
}

//fetch site information
$blog_title = get_bloginfo();
$rsslanguage = get_option('rss_language');
$descfeed = get_bloginfo_rss('description');
$siteurl = get_option('home');


//generate feed
header("Content-type: text/xml"); 
echo "<?xml version='1.0' encoding='UTF-8'?> 
<rss version='2.0'>
<channel>
<title>$blog_title | - Feed </title>
<link>$siteurl</link>
<description>$descfeed </description>
<language>$rsslanguage</language>"; 
?>
<?php do_action('rss2_head'); ?>
<?php 

//To fetch post data
$args = array(
	   'post_type' => $post_type,
	   'post_status'       => 'publish',
	   'posts_per_page' => $post_per_page,
	 );
$the_query = new WP_Query( $args ); 

if ( $the_query->have_posts() ) {
while ( $the_query->have_posts() ) : $the_query->the_post();
?><item>		
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
	<guid><?php the_permalink_rss(); ?></guid>
	<title><?php the_title_rss(); ?></title>
	<link><?php the_permalink_rss(); ?></link>
	<description><![CDATA[<?php the_content();//the_excerpt_rss(); ?>]]></description>
	<?php rss_enclosure(); ?>
	<?php do_action('rss2_item'); ?>
	</item>	
<?php endwhile; ?>
<?php } ?>
</channel>
</rss>