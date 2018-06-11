<?php get_header(); ?>
<div id="body">
    <div class="width">
        <section id="content" class="two-column with-right-sidebar">
            <?php
            if (have_posts()) :
                ?>
            <h2>
                            <?php 
                                if(is_category()){
                                    single_cat_title();
                                }else if(is_tag()){
                                    single_tag_title();
                                }else if(is_author()){
                                    the_post();
                                    echo "Author archives : ". get_the_author();
                                    rewind_posts();
                                }else if(is_day()){
                                    echo get_the_date();
                                }else if(is_month()){
                                    echo get_the_date("F Y");
                                }else if(is_year()){
                                    echo get_the_date("Y");
                                }else{
                                    echo "archives";
                                }
                                
                            ?>
                        </h2>
            <?php    while (have_posts()) : the_post();
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
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="button">Read more</a>
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
