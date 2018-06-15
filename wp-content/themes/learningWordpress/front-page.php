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
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            else:
                echo "<p>No content found</p>";
            endif;
            ?>
        </section>
        <?php get_sidebar(); ?>


        <div class="clear"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2 col-sm-2">
    </div>
    <div class="col-md-5 col-lg-5 col-sm-5">
        <div class="footer-callout">
            <div class="footer-callout-image"></div>
            <div class="footer-callout-text">
                <h2><?php echo get_theme_mod('lwp-footer-callout-headline'); ?></h2>
                <p>Dummy Text</p>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
