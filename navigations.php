<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  | BREADCRUMB CONFIG
  | -------------------------------------------------------------------
  | This file will contain some navigation' settings.
  |
  | $config['crumb_divider']		The string used to divide the crumbs
  | $config['tag_open'] 			The opening tag for navigation's holder.
  | $config['tag_close'] 			The closing tag for navigation's holder.
  | $config['crumb_open'] 		The opening tag for navigation's holder.
  | $config['crumb_close'] 		The closing tag for navigation's holder.
  |
  | Defaults provided for twitter bootstrap 2.0
 */

$config['ul_parent_tag_open'] = '<ul class="sidebar-menu">';
$config['ul_tag_close'] = '</ul>';
$config['ul_child_tag_open'] = '<ul class="treeview-menu">';
$config['li_parent_tag_open'] = '<li>';
$config['li_tag_close'] = '</li>';
$config['li_child_tag_open'] = '<li class="treeview">';
$config['arrow_in_multi_menu'] = '<i class="fa fa-angle-left pull-right"></i>';

/* End of file navigation.php */
/* Location: ./application/config/navigation.php */