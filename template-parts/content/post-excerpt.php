<?php
/**
 * Template part pour afficher l'extrait d'un article
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-excerpt bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow'); ?>>
    
    <!-- Image mise en avant -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" class="block">
                <?php 
                the_post_thumbnail('large', [
                    'class' => 'w-full h-48 object-cover',
                    'loading' => 'lazy'
                ]); 
                ?>
            </a>
            
            <!-- Badge article en vedette -->
            <?php if (function_exists('get_field') && get_field('featured_post')) : ?>
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary text-white">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <?php esc_html_e('En vedette', 'theme-moderne'); ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Contenu de l'article -->
    <div class="post-content p-6">
        
        <!-- Métadonnées -->
        <div class="post-meta flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-3">
            
            <!-- Date -->
            <time datetime="<?php echo get_the_date('c'); ?>" class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?php echo get_the_date(); ?>
            </time>

            <!-- Catégorie principale -->
            <?php 
            $categories = get_the_category();
            if ($categories) : 
                $main_category = $categories[0];
            ?>
                <a href="<?php echo get_category_link($main_category->term_id); ?>" 
                   class="inline-flex items-center gap-1 text-primary hover:text-primary-dark">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <?php echo esc_html($main_category->name); ?>
                </a>
            <?php endif; ?>

            <!-- Temps de lecture -->
            <?php 
            $content = get_post_field('post_content', get_the_ID());
            $word_count = str_word_count(strip_tags($content));
            $reading_time = ceil($word_count / 200);
            if ($reading_time > 0) :
            ?>
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php printf(_n('%d min', '%d min', $reading_time, 'theme-moderne'), $reading_time); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Titre -->
        <h2 class="post-title text-xl font-bold text-gray-900 mb-3 line-clamp-2">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                <?php the_title(); ?>
            </a>
        </h2>

        <!-- Sous-titre ACF -->
        <?php if (function_exists('get_field') && get_field('post_subtitle')) : ?>
            <p class="post-subtitle text-gray-600 font-medium mb-3">
                <?php echo esc_html(get_field('post_subtitle')); ?>
            </p>
        <?php endif; ?>

        <!-- Extrait -->
        <div class="post-excerpt-content text-gray-600 mb-4 line-clamp-3">
            <?php 
            if (has_excerpt()) {
                the_excerpt();
            } else {
                echo wp_trim_words(get_the_content(), 30, '...');
            }
            ?>
        </div>

        <!-- Footer de l'article -->
        <div class="post-footer flex items-center justify-between">
            
            <!-- Lien "Lire la suite" -->
            <a href="<?php the_permalink(); ?>" 
               class="read-more inline-flex items-center gap-2 text-primary hover:text-primary-dark font-medium text-sm transition-colors">
                <?php esc_html_e('Lire la suite', 'theme-moderne'); ?>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>

            <!-- Auteur avec avatar -->
            <div class="post-author flex items-center gap-2">
                <?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', ['class' => 'w-6 h-6 rounded-full']); ?>
                <span class="text-sm text-gray-500">
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" 
                       class="hover:text-primary">
                        <?php the_author(); ?>
                    </a>
                </span>
            </div>
        </div>
    </div>
</article>