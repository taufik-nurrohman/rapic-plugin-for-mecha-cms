<?php

$ad_config = File::open(PLUGIN . DS . 'rapic' . DS . 'states' . DS . 'config.txt')->unserialize();

function random_ad_position_in_article_and_page_content($content) {
    global $ad_config;
    $paragraph = preg_split('#<\/p>#', $content, null, PREG_SPLIT_NO_EMPTY);
    $random_index = array_rand($paragraph);
    $output = "";
    for($i = 0, $count = count($paragraph); $i < $count; ++$i) {
        if($i == $random_index) {
            $output .= $paragraph[$i] . '</p>' . $ad_config['ad_code'];
        } else {
            $output .= $paragraph[$i] . '</p>';
        }
    }
    return preg_replace('#(<\/(div|dl|figure|h[1-6]|ol|p|pre|table|ul)>)<\/p>#', '$1', $output);
}

Filter::add('article:content', 'random_ad_position_in_article_and_page_content');
Filter::add('page:content', 'random_ad_position_in_article_and_page_content');

Weapon::add('shell_after', function() use($ad_config) {
    echo '<style>' . $ad_config['ad_css'] . '</style>';
});

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