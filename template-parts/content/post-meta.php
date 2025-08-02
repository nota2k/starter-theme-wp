<?php
/**
 * Template part pour afficher les métadonnées d'un article
 */

// Ne pas afficher si c'est une page
if (is_page()) {
    return;
}
?>

<div class="post-meta flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
    
    <!-- Date de publication -->
    <div class="post-date flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <time datetime="<?php echo get_the_date('c'); ?>">
            <?php echo get_the_date(); ?>
        </time>
    </div>

    <!-- Auteur -->
    <?php if (get_the_author()) : ?>
        <div class="post-author flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span><?php esc_html_e('Par', 'theme-moderne'); ?></span>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" 
               class="author-link text-primary hover:text-primary-dark">
                <?php the_author(); ?>
            </a>
        </div>
    <?php endif; ?>

    <!-- Catégories -->
    <?php 
    $categories = get_the_category();
    if ($categories) : 
    ?>
        <div class="post-categories flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <span><?php esc_html_e('Dans', 'theme-moderne'); ?></span>
            <?php 
            $category_links = [];
            foreach ($categories as $category) {
                $category_links[] = '<a href="' . get_category_link($category->term_id) . '" class="category-link text-primary hover:text-primary-dark">' . esc_html($category->name) . '</a>';
            }
            echo implode(', ', $category_links);
            ?>
        </div>
    <?php endif; ?>

    <!-- Temps de lecture estimé -->
    <?php 
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 mots par minute
    if ($reading_time > 0) :
    ?>
        <div class="reading-time flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>
                <?php 
                printf(
                    _n('%d min de lecture', '%d min de lecture', $reading_time, 'theme-moderne'),
                    $reading_time
                );
                ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Article en vedette (si défini via ACF) -->
    <?php if (function_exists('get_field') && get_field('featured_post')) : ?>
        <div class="featured-badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary text-white">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <?php esc_html_e('En vedette', 'theme-moderne'); ?>
        </div>
    <?php endif; ?>

    <!-- Commentaires (uniquement sur single) -->
    <?php if (is_single() && comments_open()) : ?>
        <div class="post-comments flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <a href="<?php comments_link(); ?>" class="comments-link text-primary hover:text-primary-dark">
                <?php 
                $comments_count = get_comments_number();
                if ($comments_count == 0) {
                    esc_html_e('Aucun commentaire', 'theme-moderne');
                } else {
                    printf(
                        _n('%d commentaire', '%d commentaires', $comments_count, 'theme-moderne'),
                        $comments_count
                    );
                }
                ?>
            </a>
        </div>
    <?php endif; ?>
</div>