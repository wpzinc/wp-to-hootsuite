<?php
/**
 * Creates the ACTIONS-FILTERS.md markdown file, comprising of all
 * action and filter hooks parsed from the Plugin code.
 *
 * @package WPZinc
 * @author WP Zinc
 */

// Resolve all relative paths against this script's directory, so the script
// works regardless of the directory it is executed from.
chdir( __DIR__ );

// Setup Read Actions and Filters class.
require_once 'class-read-actions-filters.php';
$read_actions_filters = new Read_Actions_Filters();

// Read Plugin filters.
$filter_docs = $read_actions_filters->run(
    folders: array(
    	'../lib/social/includes',
    	'../includes',
    	'../lib/social/views',
    ),
    extract_filters: true,
    extract_actions: false,
    return_format: 'markdown',
    prefix_required: '$this->base->plugin->filter_name . \'_',
    prefix_required_replacement: '\'wp_to_hootsuite_',
    by_file: true
);
$action_docs = $read_actions_filters->run(
    folders: array(
    	'../lib/social/includes',
    	'../includes',
    	'../lib/social/views',
    ),
    extract_filters: false,
    extract_actions: true,
    return_format: 'markdown',
    prefix_required: '$this->base->plugin->filter_name . \'_',
    prefix_required_replacement: '\'wp_to_hootsuite_',
    by_file: true
);

// Build HTML.
$html = '<h1>Filters</h1>' . $filter_docs;
$html .= '<h1>Actions</h1>' . $action_docs;

echo $html;

// Write to file.
file_put_contents( '../ACTIONS-FILTERS.md', $html );
