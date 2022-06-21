<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_628a323a3d63f',
    'title' => 'Home Page Template',
    'fields' => array(
        array(
            'key' => 'field_628a3257c2194',
            'label' => 'Make Page Template',
            'name' => 'make_page_template',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => 'on',
            'ui_off_text' => 'off',
        ),
        array(
            'key' => 'field_628a328ec2195',
            'label' => 'Page Template Image',
            'name' => 'page_template_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_628a3257c2194',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'url',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        array(
            'key' => 'field_628a32d4c2196',
            'label' => 'Page Template Description',
            'name' => 'page_template_description',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_628a3257c2194',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
));

endif;		