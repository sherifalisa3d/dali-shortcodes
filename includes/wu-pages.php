<?php ?>

<div id="wu-site-template-<?php echo esc_attr($pages->ID); ?>"
    class="wu-bg-white wu-border-solid wu-border wu-border-gray-300 wu-shadow-sm wu-p-4 wu-rounded wu-relative">

    <div class="wu-site-template-image-container wu-relative">
        <a title="<?php esc_attr_e('View Template Preview', 'wp-ultimo'); ?>"
            class="wu-site-template-selector wu-cursor-pointer wu-no-underline"
            href="<?php echo get_permalink($pages->ID); ?>" target="_blank">

            <img class="wu-site-template-image wu-w-full wu-border-solid wu-border wu-border-gray-300 wu-mb-4 wu-bg-white"
                src="<?php echo esc_attr(get_field('page_template_image', $pages->ID)); ?>">
        </a>

    </div>

    <h3 class="wu-site-template-title wu-text-lg wu-font-semibold">

        <?php echo  $pages->post_title; ?>

    </h3>

    <p class="wu-site-template-description wu-text-sm">

        <?php echo esc_attr( get_field('page_template_description', $pages->ID) ); ?>

    </p>

    <div class="wu-mt-4">
        <a href="#" class="dali-template-selector template-id-<?php echo esc_attr($pages->ID); ?> button btn button-primary btn-primary wu-w-full wu-text-center wu-cursor-pointer"
            data-id="<?php echo esc_attr($pages->ID); ?>">
            <span><?php _e('Select', 'wp-ultimo'); ?></span>
        </a>
        <a title="<?php esc_attr_e('View Template Preview', 'wp-ultimo'); ?>"
            class="dali-template-preview button btn button-primary btn-primary wu-w-full wu-text-center wu-cursor-pointer"
            href="<?php echo get_permalink($pages->ID); ?>" target="_blank">
            <span><?php esc_attr_e('Preview', 'wp-ultimo'); ?></span>
        </a>
    </div>

</div>