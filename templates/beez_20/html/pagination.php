<?php
/**
 * @version � 2.6 April 10, 2012
 * @author � �RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license � http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 * 	Input variable $list is an array with offsets:
 * 		$list[limit]		: int
 * 		$list[limitstart]	: int
 * 		$list[total]		: int
 * 		$list[limitfield]	: string
 * 		$list[pagescounter]	: string
 * 		$list[pageslinks]	: string
 *
 * pagination_list_render
 * 	Input variable $list is an array with offsets:
 * 		$list[all]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[start]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[previous]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[next]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[end]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[pages]
 * 			[{PAGE}][data]		: string
 * 			[{PAGE}][active]	: boolean
 *
 * pagination_item_active
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * pagination_item_inactive
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_render($list)
{
	// Initialize variables
	$lang = JFactory::getLanguage();
	$html = null;
	
	if ($list['start']['active']) {
		$html .= ' '.$list['start']['data'];
	} else {
		$html .= ' '.$list['start']['data'];
	}
	if ($list['previous']['active']) {
		$html .= ' '.$list['previous']['data'];
	} else {
		$html .= ' '.$list['previous']['data'];
	}

	foreach( $list['pages'] as $page ) {
		$html .= ' '.(!$page['active']?str_replace('<a ', '<a class="current" ', $page['data']):$page['data']);
	}
	$html .= "";

	if ($list['next']['active']) {
		$html .= ' '.$list['next']['data'];
	} else {
		$html .= ' '.$list['next']['data'];
	}
	if ($list['end']['active']) {
		$html .= ' '.$list['end']['data'];
	} else {
		$html .= ' '.$list['end']['data'];
	}

	return str_replace('篇', '页', $html);
}

function pagination_item_active(&$item)
{
	if($item->base>0)
		return "<a href=\".$item->link.\" title=\"".$item->text."\" >".$item->text."</a>";
	else
		return "<a href=\".$item->link.\" title=\"".$item->text."\" >".$item->text."</a>";
}

function pagination_item_inactive(&$item)
{
	return "<a href=\"javascript:;\" rel=\"nofollow\" >".$item->text."</a>";
}
?>
