<?php

// Load the configuration data
$rapic_config = File::open(PLUGIN . DS . basename(__DIR__) . DS . 'states' . DS . 'config.txt')->unserialize();

// The random ad position function
function do_random_ad_position_in_article_and_page_content($content) {
    global $rapic_config;
    $paragraph = explode('</p>', $content);
    array_splice($paragraph, array_rand($paragraph), 0, $rapic_config['ad_code'] . '<rapic:end>');
    $paragraph = implode('</p>', $paragraph);
    return str_replace(array('<rapic:end></p>', '<rapic:end>'), "", $paragraph);
}

// Register the filters
Filter::add('article:content', 'do_random_ad_position_in_article_and_page_content');
Filter::add('page:content', 'do_random_ad_position_in_article_and_page_content');

// Include the CSS
Weapon::add('shell_after', function() use($config, $rapic_config) {
    echo O_BEGIN . '<style>' . ($config->html_minifier ? Converter::detractShell($rapic_config['ad_css']) : NL . $rapic_config['ad_css'] . NL) . '</style>' . O_END;
});