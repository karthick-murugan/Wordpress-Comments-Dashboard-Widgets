<?php
 /*
 * Plugin Name:	Wordpress Comments Dashboard Widgets
 * URI: 		#
 * Description: A simple wordpress plugin for displaying comments in dashboard.
 * Version: 	1.0
 * Author: 		Karthick
 * Author URI:	https://www.linkedin.com/in/karthick-m-a4221b201/
 */

class WordPress_Dashboard_Widget
{
    
    public function __construct()
    {

        add_action('wp_dashboard_setup', array( $this, 'wordpress_dashboard_widget' ));
    }

    public function wordpress_dashboard_widget()
    {
       
        wp_add_dashboard_widget(
            'wordpress_dashboard_widget_id',
            'Wordpress Dashboard Widget',
            array( $this, 'data_callback' ),
            array( $this, 'control_callback' ),
            array(
                'content' => __('Latest Posts', ''),
            ),
        );
    }

    public function data_callback( $screen, $widget_args )
    {

        $comments_count   = get_option('wordpress_dashboard_comments_count', 5);
        $comments         = get_comments(
            array(
            'number'      => $comments_count,          // Number of comments to retrieve
            'status'      => 'approve',  // Only approved comments
            'post_status' => 'publish',  // Only comments on published posts
            )
        );
        
        foreach ($comments as $comment) {
            $author_name = $comment->comment_author;
            $comment_content = $comment->comment_content;
            $comment_date = $comment->comment_date;
        
            echo "Author: $author_name<br>";
            echo "Comment: $comment_content<br>";
            echo "Date: $comment_date<br>";
            echo "<hr>";
        }
        
    }

    public function control_callback()
    {

        if (isset($_POST['wordpress_dashboard_comments_count'])) {
            update_option('wordpress_dashboard_comments_count', sanitize_text_field($_POST['wordpress_dashboard_comments_count']));
        }
        $number_posts = get_option('wordpress_dashboard_comments_count', 5);
        echo '<label>Enter Comments Count</label>';
        echo '<input type="text" name="wordpress_dashboard_comments_count" value='.$number_posts.' />';
    }
}

$wordpress_dashboard_widget = new WordPress_Dashboard_Widget();
