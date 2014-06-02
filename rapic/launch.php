<?php

$ad_config = unserialize(File::open(PLUGIN . DS . 'rapic' . DS . 'states' . DS . 'config.txt')->read());

if( ! $language = File::exist(PLUGIN . DS . 'rapic' . DS . 'languages' . DS . $config->language . DS . 'speak.txt')) {
    $language = PLUGIN . DS . 'rapic' . DS . 'languages' . DS . 'en_US' . DS . 'speak.txt';
}

Config::merge('speak', Text::toArray(File::open($language)->read()));

function random_ad_position_in_article_and_page_content($content) {
    global $ad_config;
    $paragraphs = explode('</p>', $content);
    $paragraphs[array_rand($paragraphs)] .= '</p>' . $ad_config['ad_code'] . '[end_ad_code]';
    $content = implode('</p>', $paragraphs);
    return str_replace(array('[end_ad_code]</p>', '[end_ad_code]'), "", $content);
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
        File::write(serialize($request))->saveTo(PLUGIN . DS . 'rapic' . DS . 'states' . DS . 'config.txt');
        Notify::success(Config::speak('notify_success_updated', array($speak->plugin)));
        Guardian::kick(dirname($config->url_current));
    }

});