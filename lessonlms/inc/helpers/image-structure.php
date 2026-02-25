<?php
/**
 * Load image / SVG from theme assets
 *
 * @param string $filename  File name with extension, e.g. 'icon.svg'
 * @param string $alt       Alt text
 * @param string $class     Optional CSS class
 * @param string $folder    Optional subfolder inside assets, default 'images'
 * @return string HTML <img> tag
 */
function lessonlms_asset_svg( $sub_folder, $filename, $alt = '', $class = '', $folder = 'svg' ) {
    $theme_uri = get_template_directory_uri();
    $src = esc_url( $theme_uri . '/assets/' . $folder . '/' . $sub_folder . '/' . $filename );
    $alt_attr = esc_attr( $alt );
    $class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';

    return '<img src="' . $src . '" alt="' . $alt_attr . '"' . $class_attr . '>';
}

