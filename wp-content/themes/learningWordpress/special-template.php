<?php 
/* Template Name: Special Layout */
get_header(); ?>
<?php if(is_page('home') || is_front_page()){ ?>
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
            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>
                    <article>


                        <h2><?php the_title(); ?></h2>
                        <div class="article-info">Posted on <time datetime="2013-05-14">14 May</time> by <a href="#" rel="author">Joe Bloggs</a></div>
                        <?php the_content(); ?>
                        <a href="#" class="button">Read more</a>
                    </article>
                    <?php
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
<?php get_footer(); ?>
