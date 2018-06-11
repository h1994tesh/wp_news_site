<?php get_header(); ?>
<?php if (is_page('home') || is_front_page()) { ?>
    <div id="intro">

        <div class="width">

            <div class="intro-content">

                <h2>Tristique sem vitae metus ornare </h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                <p><a href="#" class="button button-slider"><i class="fa fa-gbp"></i> Lorem ipsum dolor</a>
                    <a href="#" class="button button-reversed button-slider"><i class="fa fa-info"></i> Consectetuer adipiscing</a></p>


            </div>

        </div>


    </div>
<?php } ?>
<div id="body">



    <div class="width">
        <section id="content" class="two-column with-right-sidebar">
            <?php
            $pst = new WP_Query('cat=6&posts_per_page=3&orderby=title&order=desc');
            if ($pst->have_posts()) :
                while ($pst->have_posts()) : $pst->the_post();
                    get_template_part('content', get_post_format());
                endwhile;
            else:
                echo "<p>No content found</p>";
            endif;
//            wp_reset_postdata();
            ?>
        </section>
<?php get_sidebar(); ?>


        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>
