<?php

// Load the configuration data
$rapic_config = File::open(__DIR__ . DS . 'states' . DS . 'config.txt')->unserialize();

// The random ad position function
function do_rapic($content, $results = array()) {
    $results = Mecha::O($results);
    if(isset($results->fields->disable_rapic) && $results->fields->disable_rapic !== false) {
        return $content;
    }
    global $rapic_config;
    $p = explode('</p>', $content);
    array_splice($p, array_rand($p), 0, $rapic_config['html'] . '<rapic:end>');
    $p = implode('</p>', $p);
    return str_replace(array('<rapic:end></p>', '<rapic:end>'), "", $p);
}

if($config->is->post) {
    // Apply `do_rapic` filter
    Filter::add($config->page_type . ':content', 'do_rapic');
    // Apply skin to page
    Weapon::add('shell_after', function() use($config, $rapic_config) {
        echo O_BEGIN . '<style media="screen">' . NL . $rapic_config['css'] . NL . '</style>' . O_END;
    });
}