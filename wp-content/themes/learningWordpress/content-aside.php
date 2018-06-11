<article class="post-aside">


                        <div class="article-info">Posted on <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('d/m/Y'); ?></time> | by <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author"><?php the_author(); ?></a> | Posted in <?php
                            $categories = get_the_category();
                            $separator = ", ";
                            $output = "";
                            if ($categories) {
                                foreach ($categories as $category) {
                                    $output .= '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . $separator;
                                }
                                echo trim($output, $separator);
                            }
                            ?></div>
                            <?php the_post_thumbnail('banner-image'); ?>
                            <?php if ($post->post_excerpt) { ?>
                            <?php echo get_the_excerpt(); ?>
                               
                            <a href="<?php the_permalink(); ?>" class="button">Read more</a>
                        <?php
                        } else {
                            the_content();
                        }
                        ?>

                    </article>