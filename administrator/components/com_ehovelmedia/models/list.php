<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
<<<<<<< HEAD

=======
jimport('joomla.application.component.modellist');
>>>>>>> ac367e4d9fe39b2192081c2634da77d1a41e8588
/**
 * Media Component List Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_media
 * @since 1.5
 */
<<<<<<< HEAD
class EhovelmediaModelList extends JModelLegacy
=======
class EhovelmediaModelList extends JModelList
>>>>>>> ac367e4d9fe39b2192081c2634da77d1a41e8588
{
	public $category_id = 0;
	function _buildQuery()
	{
		$where = $this->category_id ? 'WHERE category_id='.$this->category_id : '';
		$query = "SELECT * FROM ".$this->_db->nameQuote('#__ehovel_resources')." $where ORDER BY ".$this->_db->nameQuote('date_add')." DESC";
	
		return $query;
	}
	
	function getImages()
	{
		$list = $this->getData();
	
		return $list['images'];
	}
	
	function getData() {
		//当前分类id
		$categoryId = $this->getState('folder');
		if ($categoryId) {
			$this->category_id = $categoryId;
		}
		if(empty($this->_data))
		{
			$query = $this->_buildQuery();
<<<<<<< HEAD
			$this->_data['images'] = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
=======
			$this->_data['images'] = $this->_getList($query, $this->getState('list.start'), $this->getState('list.limit'));
>>>>>>> ac367e4d9fe39b2192081c2634da77d1a41e8588
		}
		
		return $this->_data;
	}
<<<<<<< HEAD
=======
	
>>>>>>> ac367e4d9fe39b2192081c2634da77d1a41e8588
	function getState($property = null, $default = null)
	{
		static $set;

		if (!$set) {
			$folder = JRequest::getVar('folder', '', '', 'path');
			$this->setState('folder', $folder);

			$parent = str_replace("\\", "/", dirname($folder));
			$parent = ($parent == '.') ? null : $parent;
			$this->setState('parent', $parent);
			$set = true;
		}

		return parent::getState($property, $default);
	}

	function getFolders()
	{
		$list = $this->getList();

		return $list['folders'];
	}

	function getDocuments()
	{
		$list = $this->getList();

		return $list['docs'];
	}

	/**
	 * Build imagelist
	 *
	 * @param string $listFolder The image directory to display
	 * @since 1.5
	 */
	function getList()
	{
		static $list;

		// Only process the list once per request
		if (is_array($list)) {
			return $list;
		}
		
		
		// Get current path from request
		$current = $this->getState('folder');

		// If undefined, set to empty
		if ($current == 'undefined') {
			$current = '';
		}

		// Initialise variables.
		if (strlen($current) > 0) {
			$basePath = COM_MEDIA_BASE.'/'.$current;
		}
		else {
			$basePath = COM_MEDIA_BASE;
		}

		$mediaBase = str_replace(DIRECTORY_SEPARATOR, '/', COM_MEDIA_BASE.'/');

		$images		= array ();
		$folders	= array ();
		$docs		= array ();

		$fileList = false;
		$folderList = false;
		if (file_exists($basePath))
		{
			// Get the list of files and folders from the given folder
			$fileList	= JFolder::files($basePath);
			$folderList = JFolder::folders($basePath);
		}
		
		// Iterate over the files if they exist
		if ($fileList !== false) {
			foreach ($fileList as $file)
			{
				if (is_file($basePath.'/'.$file) && substr($file, 0, 1) != '.' && strtolower($file) !== 'index.html') {
					$tmp = new JObject();
					$tmp->name = $file;
					$tmp->title = $file;
					$tmp->path = str_replace(DIRECTORY_SEPARATOR, '/', JPath::clean($basePath . '/' . $file));
					$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
					$tmp->size = filesize($tmp->path);

					$ext = strtolower(JFile::getExt($file));
					switch ($ext)
					{
						// Image
						case 'jpg':
						case 'png':
						case 'gif':
						case 'xcf':
						case 'odg':
						case 'bmp':
						case 'jpeg':
						case 'ico':
							$info = @getimagesize($tmp->path);
							$tmp->width		= @$info[0];
							$tmp->height	= @$info[1];
							$tmp->type		= @$info[2];
							$tmp->mime		= @$info['mime'];

							if (($info[0] > 60) || ($info[1] > 60)) {
								$dimensions = EhovelmediaHelper::imageResize($info[0], $info[1], 60);
								$tmp->width_60 = $dimensions[0];
								$tmp->height_60 = $dimensions[1];
							}
							else {
								$tmp->width_60 = $tmp->width;
								$tmp->height_60 = $tmp->height;
							}

							if (($info[0] > 16) || ($info[1] > 16)) {
								$dimensions = EhovelmediaHelper::imageResize($info[0], $info[1], 16);
								$tmp->width_16 = $dimensions[0];
								$tmp->height_16 = $dimensions[1];
							}
							else {
								$tmp->width_16 = $tmp->width;
								$tmp->height_16 = $tmp->height;
							}

							$images[] = $tmp;
							break;

						// Non-image document
						default:
							$tmp->icon_32 = "media/mime-icon-32/".$ext.".png";
							$tmp->icon_16 = "media/mime-icon-16/".$ext.".png";
							$docs[] = $tmp;
							break;
					}
				}
			}
		}

		// Iterate over the folders if they exist
		if ($folderList !== false) {
			foreach ($folderList as $folder)
			{
				$tmp = new JObject();
				$tmp->name = basename($folder);
				$tmp->path = str_replace(DIRECTORY_SEPARATOR, '/', JPath::clean($basePath . '/' . $folder));
				$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
				$count = EhovelmediaHelper::countFiles($tmp->path);
				$tmp->files = $count[0];
				$tmp->folders = $count[1];

				$folders[] = $tmp;
			}
		}

		$list = array('folders' => $folders, 'docs' => $docs, 'images' => $images);

		return $list;
	}
}
