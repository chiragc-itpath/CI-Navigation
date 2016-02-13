<?php

/**
 * Navigation Class
 *
 * This class manages the navigation object for codeigniter.
 * Create the main function to build milti-level menu. It is a recursive function.
 * 
 * @package		Navigation
 * @version		1.0
 * @author 		Chirag <chiragc@itpathsolutions.co.in>
 * @copyright           Copyright (c) 2015, itpathsolutions
 * @testdox             CI - 3.0, 2.0
 */
class Navigation {

    /**
     * Navigations stack
     * create a multidimensional array to hold a list of menu and parent menu
     */
    private $navigations = array(
        'menus' => array(),
        'parent_menus' => array()
    );

    /**
     * Constructor
     * 
     * @access public
     */
    public function __construct() {
        $this->ci = & get_instance();
        // Load config file
        $this->ci->load->config('navigations');

        // Get navigation display options
        $this->ul_parent_tag_open = $this->ci->config->item('ul_parent_tag_open');
        $this->ul_tag_close = $this->ci->config->item('ul_tag_close');
        $this->ul_child_tag_open = $this->ci->config->item('ul_child_tag_open');
        $this->li_parent_tag_open = $this->ci->config->item('li_parent_tag_open');
        $this->li_tag_close = $this->ci->config->item('li_tag_close');
        $this->li_child_tag_open = $this->ci->config->item('li_child_tag_open');
        $this->arrow_in_multi_menu = $this->ci->config->item('arrow_in_multi_menu');

        log_message('debug', "Navigation Class Initialized");
    }

    /**
     * Append crumb to stack
     * build the array lists with data from the menu table
     * 
     * @access public
     * @param array $sqlObject
     * @return void 
     */
    public function push($sqlObject) {

        foreach ($sqlObject as $i => $row) {
            //creates entry into menus array with current menu id 
            //ie. $this->navigations['menus'][1]
            $this->navigations['menus'][$row->id] = (array) $row;
            //creates entry into parent_menus array. parent_menus array contains
            // a list of all menus with children
            $this->navigations['parent_menus'][$row->parentid][] = $row->id;
        }
    }

    /**
     * Generate navigation
     *
     * @access	public
     * @param int $parent from where to navigation start
     * @return string HTML
     */
    public function show($parent = 0) {
        $html = "";
        if (isset($this->navigations['parent_menus'][$parent])) {

            $html = $parent == 0 ? $this->ul_parent_tag_open : $this->ul_child_tag_open;

            foreach ($this->navigations['parent_menus'][$parent] as $menu_id) {

                if (!isset($this->navigations['parent_menus'][$menu_id])) {
                    if ($this->navigations['menus'][$menu_id]['is_header']) {
                        $html .= "<li class='header'>" . $this->navigations['menus'][$menu_id]['title'] . "</li>";
                    } else {
                        $html .= $this->li_parent_tag_open
                                . "<a href='" . $this->navigations['menus'][$menu_id]['link'] . "'>"
                                . "<i class='fa " . $this->navigations['menus'][$menu_id]['icon'] . "'></i>"
                                . "<span>" . $this->navigations['menus'][$menu_id]['title'] . "</span>";
                        if ($this->navigations['menus'][$menu_id]['is_labeled']) {
                            $html .= "<small class='label pull-right'></small>";
                        }
                        $html .= "</a>" . $this->li_tag_close;
                    }
                }

                if (isset($this->navigations['parent_menus'][$menu_id])) {
                    $html .= $this->li_child_tag_open
                            . "<a href='" . $this->navigations['menus'][$menu_id]['link'] . "'>"
                            . "<i class='fa " . $this->navigations['menus'][$menu_id]['icon'] . "'></i>"
                            . "<span>" . $this->navigations['menus'][$menu_id]['title'] . "</span>"
                            . $this->arrow_in_multi_menu
                            . "</a>";
                    $html .= $this->show($menu_id);
                    $html .= $this->li_tag_close;
                }
            }
            $html .= $this->ul_tag_close;
        }
        return $html;
    }

}
