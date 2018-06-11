<?php get_header(); ?>
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


                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="article-info">Posted on <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('d/m/Y'); ?></time> | by <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author"><?php the_author(); ?></a> | Posted in <?php 
                            $categories = get_the_category(); 
                            $separator = ", ";
                            $output = "";
                            if($categories){
                                foreach ($categories as $category){
                                    $output .= '<a href="'.  get_category_link($category->term_id).'">'.$category->cat_name .'</a>'. $separator;
                                }
                                echo trim($output, $separator);
                            }
                        ?></div>
                        <?php the_post_thumbnail(); ?>
                            <?php if ($post->post_excerpt) { ?>
                            <?php echo get_the_excerpt(); ?>
                               
                            <a href="<?php the_permalink(); ?>" class="button">Read more</a>
                        <?php
                        } else {
                            the_content();
                        }
                        ?>
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
