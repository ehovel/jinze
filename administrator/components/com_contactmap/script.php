<?php
	/*
	* GMapFP Component ContactMap for Joomla! 1.6.x
	* Version 4.6
	* Creation date: Octobre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access');
 
class com_ContactMapInstallerScript
{
        private $_version_num = "4.9";

		/**
         * method to install the component
         * @return void
         */
        function install($parent) 
        {
			$path = JPATH_SITE;

			//Installation du fichier CSS
			$filesource = $path .DS.'components'.DS.'com_contactmap'.DS.'views'.DS.'contactmap'.DS.'contactmap3.css';
			$filedest = $path .DS.'components'.DS.'com_contactmap'.DS.'views'.DS.'contactmap'.DS.'contactmap.css';
			JFile::copy($filesource, $filedest,null);
			
			$db =& JFactory::getDBO();

		/**************************************************/
		// Ajout des éléments à la table contact_détails  //
		/**************************************************/
				//$query = "SELECT message FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'message'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `message` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `misc` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT horaires_prix FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'horaires_prix'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `horaires_prix` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `message` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT link FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'link'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `link` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `horaires_prix` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT article_id FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'article_id'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `article_id` INT(100) NOT NULL DEFAULT '0' AFTER  `link` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT icon FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'icon'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `icon` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `article_id` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT icon_label FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'icon_label'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `icon_label` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `icon` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT affichage FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'affichage'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `affichage` SMALLINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `icon_label` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT marqueur FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'marqueur'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `marqueur` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `affichage` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT glng FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'glng'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `glng` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `marqueur` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT glat FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'glat'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `glat` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `glng` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT gzoom FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'gzoom'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `gzoom` VARCHAR(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `glat` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT metadesc FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'metadesc'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `metadesc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `gzoom` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};
		
				//$query = "SELECT metakey FROM `#__contact_details`;";
				$query = "SHOW COLUMNS FROM `#__contact_details` LIKE 'metakey'";
				$db->setQuery( $query );
				$list_id = $db->loadObject();
				if (empty($list_id)) {
					$query = "ALTER TABLE  `#__contact_details` ADD  `metakey` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER  `metadesc` ;";
					$db->setQuery($query);
					$db->query();
					if ($db->getErrorNum()) {
						exit($db->stderr());
					}
				};

				/*mise à jour des données marqueurs*/
				$query = "INSERT INTO `#__contactmap_marqueurs` VALUES 
		('', 'marqueur', 'http://www.google.com/mapfiles/marker.png',1),
		('', 'marqueur home', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|home|FFFF00|FF0000',1),
		('', 'marqueur flag', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|flag|FFFF00|FF0000',1),
		('', 'marqueur info', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|info|FFFF00|FF0000',1),
		('', 'marqueur bar', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|bar|FFFF00|FF0000',1),
		('', 'marqueur cafe', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|cafe|FFFF00|FF0000',1),
		('', 'marqueur perso', 'http://chart.apis.google.com/chart?chst=d_map_spin&chld=1.2|0|FF0000|10|_|foo|bar',1),
		('', 'marqueurA', 'http://www.google.com/mapfiles/markerA.png',1),
		('', 'marqueurB', 'http://www.google.com/mapfiles/markerB.png',1),
		('', 'marqueurC', 'http://www.google.com/mapfiles/markerC.png',1),
		('', 'marqueurD', 'http://www.google.com/mapfiles/markerD.png',1),
		('', 'marqueurE', 'http://www.google.com/mapfiles/markerE.png',1),
		('', 'marqueurF', 'http://www.google.com/mapfiles/markerF.png',1),
		('', 'marqueurG', 'http://www.google.com/mapfiles/markerG.png',1),
		('', 'marqueurH', 'http://www.google.com/mapfiles/markerH.png',1),
		('', 'marqueurI', 'http://www.google.com/mapfiles/markerI.png',1),
		('', 'marqueurJ', 'http://www.google.com/mapfiles/markerJ.png',1),
		('', 'marqueurK', 'http://www.google.com/mapfiles/markerK.png',1),
		('', 'marqueurL', 'http://www.google.com/mapfiles/markerL.png',1),
		('', 'marqueurM', 'http://www.google.com/mapfiles/markerM.png',1),
		('', 'marqueurN', 'http://www.google.com/mapfiles/markerN.png',1),
		('', 'marqueurO', 'http://www.google.com/mapfiles/markerO.png',1),
		('', 'marqueurP', 'http://www.google.com/mapfiles/markerP.png',1),
		('', 'marqueurQ', 'http://www.google.com/mapfiles/markerQ.png',1),
		('', 'marqueurR', 'http://www.google.com/mapfiles/markerR.png',1),
		('', 'marqueurS', 'http://www.google.com/mapfiles/markerS.png',1),
		('', 'marqueurT', 'http://www.google.com/mapfiles/markerT.png',1),
		('', 'marqueurU', 'http://www.google.com/mapfiles/markerU.png',1),
		('', 'marqueurV', 'http://www.google.com/mapfiles/markerV.png',1),
		('', 'marqueurW', 'http://www.google.com/mapfiles/markerW.png',1),
		('', 'marqueurX', 'http://www.google.com/mapfiles/markerX.png',1),
		('', 'marqueurY', 'http://www.google.com/mapfiles/markerY.png',1),
		('', 'marqueurZ', 'http://www.google.com/mapfiles/markerZ.png',1),
		('', 'marqueurBleu', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/blue-dot.png',1),
		('', 'marqueurVert', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/green-dot.png',1),
		('', 'marqueurOrange', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/orange-dot.png',1),
		('', 'marqueurJaune', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/yellow-dot.png',1),
		('', 'marqueurViolet', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/purple-dot.png',1),
		('', 'marqueurRose','http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/pink-dot.png',1),
		('', 'purple', 'http://labs.google.com/ridefinder/images/mm_20_purple.png',1),
		('', 'yellow', 'http://labs.google.com/ridefinder/images/mm_20_yellow.png',1),
		('', 'blue', 'http://labs.google.com/ridefinder/images/mm_20_blue.png',1),
		('', 'white', 'http://labs.google.com/ridefinder/images/mm_20_white.png',1),
		('', 'green', 'http://labs.google.com/ridefinder/images/mm_20_green.png',1),
		('', 'red', 'http://labs.google.com/ridefinder/images/mm_20_red.png',1),
		('', 'black', 'http://labs.google.com/ridefinder/images/mm_20_black.png',1),
		('', 'orange', 'http://labs.google.com/ridefinder/images/mm_20_orange.png',1),
		('', 'gray', 'http://labs.google.com/ridefinder/images/mm_20_gray.png',1),
		('', 'brown', 'http://labs.google.com/ridefinder/images/mm_20_brown.png',1);";
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					exit($db->stderr());
				}

			$this->affiche_bienvenue(1);

			// $parent is the class calling this method
			//$parent->getParent()->setRedirectURL('index.php?option=com_gmapfp');
        }
 
        /**
         * method to uninstall the component
         * @return void
         */
/*        function uninstall($parent) 
        {
                // $parent is the class calling this method
                echo '<p>' . JText::_('COM_GMAPFP_UNINSTALL_TEXT') . '</p>';
        }
 
        /**
         * method to update the component
         *
         * @return void
         */
        function update($parent) 
        {
                // $parent is the class calling this method
			$this->affiche_bienvenue(0);
        }
 
		function affiche_bienvenue($install) {
			if ($install == 1) {
				echo "<h1>ContactMap Installation</h1>";
			}else{
				echo "<h1>ContactMap Mise &agrave; jour</h1>";
			};
			?>
			<p>Bienvenue sur ContactMap v<?php echo $this->_version_num?> !<br/>
			Avant de commencer, je vous invite, si ce n'est pas d&eacute;j&agrave; fait, &agrave; d&eacute;couvrir son <a target="_blank" href="http://gmapfp.org/fr">Site officiel</a>.<br />
			Vous pourrez y <a target="_blank" href="http://gmapfp.org/fr/telechargement">t&eacute;l&eacute;charger</a> les mise &agrave; jours et consulter le <a target="_blank" href="http://gmapfp.org/fr/forum"> forum</a>.</p>
			<p>Au revoir, et bonne continuation avec GMapFP</p>
			<br />
			<br />
			<br />
			<?php
			if ($install == 1) {
				echo "<h1>ContactMap Installation (in English)</h1>";
			}else{
				echo "<h1>ContactMap Upgrade (in English)</h1>";
			};
			?>
			<p>Welcome on v<?php echo $this->_version_num?> ContactMap !<br/>
			Before starting, I invite you, if this isn't already made, to discovery the <a target="_blank" href="http://www.gmapfp.org/en">Official Site</a>.<br />
			You will be able there to <a target="_blank" href="http://gmapfp.org/en/download">download</a> the update and consult the <a target="_blank" href="http://gmapfp.org/en/forum"> forum</a>.</p>
			<p>Goodbye, and good continuation with GMapFP</p>
			
			<?php
        }
        function preflight($type, $parent)
        {
                // $parent is the class calling this method
                // $type is the type of change (install, update or discover_install)
                //echo '<p>' . JText::_('COM_GMAPFP_PREFLIGHT_' . $type . '_TEXT') . '</p>';
        }

        /**
         * method to run after an install/update/uninstall method
         *
         * @return void
         */
        function postflight($type, $parent)
        {
			// $parent is the class calling this method
			// $type is the type of change (install, update or discover_install)
			
			if ($type == 'install') {
		
				$db =& JFactory::getDBO();
				/*mise à jour des paramètres par défaut*/
				$query = 'UPDATE `#__extensions` SET params=\'{"contactmap_height":"400",
				"contactmap_auto":"1",
				"contactmap_centre_lat":"47.93083631244",
				"contactmap_centre_lng":"2.140960693359375",
				"contactmap_zoom":"7",
				"contactmap_zoom_lightbox_carte":"0",
				"contactmap_zoom_lightbox_imprimer":"0",
				"contactmap_width_bulle_contactmap":"400",
				"contactmap_taille_bulle_cesure":"150",
				"contactmap_photo_icon":"0",
				"contactmap_itineraire":"1",
				"contactmap_traffic":"1",
				"contactmap_streetView":"1",
				"contactmap_height_sv":"400",
				"contactmap_normal":"1",
				"contactmap_satellite":"1",
				"contactmap_hybrid":"1",
				"contactmap_physic":"1",
				"contactmap_vertical":"1",
				"contactmap_choix_affichage_carte":"1",
				"contactmap_mapcontrol":"1",
				"contactmap_scalecontrol":"1",
				"contactmap_mousewheel":"1",
				"contactmap_plus_info":"1",
				"contactmap_afficher_horaires_prix":"1",
				"contactmap_hauteur_img":"100",
				"contactmap_afficher_captcha":"1",
				"contactmap_geoXML":"",
				"contactmap_licence":"1"}\' WHERE name=\'contactmap\'';
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					exit($db->stderr());
				}
			}
			
			//@mail('webmaster@gmapfp.org','ContactMap v'.$this->_version_num.' '.$type,$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],'From:webmaster@gmapfp.org');
			//echo '<p>' . JText::_('COM_GMAPFP_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
        }
}