<?php

// Load the configuration file
$rapic_config = File::open(PLUGIN . DS . 'rapic' . DS . 'states' . DS . 'config.txt')->unserialize();

// The random ad position function
function do_random_ad_position_in_article_and_page_content($content) {
    global $rapic_config;
    $paragraph = explode('</p>', $content);
    array_splice($paragraph, array_rand($paragraph), 0, $rapic_config['ad_code'] . '<rapic:end>');
    $paragraph = implode('</p>', $paragraph);
    return str_replace(array('<rapic:end></p>', '<rapic:end>'), "", $paragraph);
}

// Register the filter
Filter::add('article:content', 'do_random_ad_position_in_article_and_page_content');
Filter::add('page:content', 'do_random_ad_position_in_article_and_page_content');

Weapon::add('shell_after', function() use($rapic_config) {
    echo '<style>' . $rapic_config['ad_css'] . '</style>';
});


/**
 * Plugin Updater
 * --------------
 */

Route::accept($config->manager->slug . '/plugin/rapic/update', function() use($config, $speak) {
    if( ! Guardian::happy()) {
        Shield::abort();
    }
    if($request = Request::post()) {
        Guardian::checkToken($request['token']);
        unset($request['token']); // Remove token from request array
        File::serialize($request)->saveTo(PLUGIN . DS . 'rapic' . DS . 'states' . DS . 'config.txt');
        Notify::success(Config::speak('notify_success_updated', array($speak->plugin)));
        Guardian::kick(dirname($config->url_current));
    }
});