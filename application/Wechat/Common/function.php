<?php

/**
 * 根据过滤条件获得排序的标记
 *
 * @access public
 * @param array $filter            
 * @return array
 */
function sort_flag($filter)
{
    $flag['tag'] = 'sort_' . preg_replace('/^.*\./', '', $filter['sort_by']);
    $flag['img'] = '<img src="' .__PUBLIC__. '/images/' . ($filter['sort_order'] == "DESC" ? 'sort_desc.gif' : 'sort_asc.gif') . '"/>';
    
    return $flag;
}