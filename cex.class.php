<?php
 /* Project: EQdkp-Plus
* Package: The Secret World game package
* Link: http://eqdkp-plus.eu
*
* Copyright (C) 2006-2016 EQdkp-Plus Developer Team
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published
* by the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('cex')) {
	class cex extends game_generic {
		protected static $apiLevel	= 20;
		public $version				= '0.0.1';
		protected $this_game		= 'cex';
		public $author				= "Inkraja";
		public $types				= array('races', 'classes', 'religions', 'events', 'roles', 'servers');
		protected $classes			= array();
		protected $factions			= array();
		protected $filters			= array();
		public $langs				= array('english', 'german');

		public $game_settings		= array(
			'calendar_hide_emptyroles'	=> true,    /*Calendar Hide Roles if zero*/
		);
		
		protected $class_dependencies = array(
			array(
				'name'		=> 'religion',
				'type'		=> 'religions',
				'admin' 	=> false,
				'decorate'	=> true,
				'roster' 	=> true,
				'parent'	=> false,
				'primary'	=> true,
				'colorize'	=> false,
				'recruitment' => true,

			),
			array(
				'name'		=> 'server',
				'type'		=> 'servers',
				'admin'		=> true,
				'decorate'	=> false,
				'primary'	=> false,
				'roster'	=> false,
				'colorize'	=> false,
				'parent'	=> false,
				'recruitment' => false,
			),
			array(
				'name'		=> 'class',
				'type'		=> 'classes',
				'admin'		=> false,
				'decorate'	=> true,
				'primary'	=> true,
				'roster'	=> false,
				'colorize'	=> true,
				'parent'	=> false,
				'recruitment' => false,
			),
		);

	public $default_roles = array(

			0 	=> array(1,2,3,4),			# Healer
			1 	=> array(1,2,3,4),			# Tank
			2 	=> array(1,2,3,4),			# DPS
			3 	=> array(1,2,3,4),			# Melee
			
		);

	public function profilefields(){
			$xml_fields = array(
				'guild'	=> array(
					'type'			=> 'text',
					'category'		=> 'character',
					'lang'			=> 'uc_guild',
					'size'			=> 25,
					'undeletable'	=> true,
					),
				'level'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'character',
					'lang'			=> 'uc_level',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_health'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_health',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_stamina'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_stamina',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_ecumbrance'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_ecumbrance',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_might'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_might',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_accuracy'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_accuracy',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_atleticism'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_atleticism',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_metabolism'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_metabolism',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'stat_resilience'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'stats',
					'lang'			=> 'uc_resilience',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
				'religion'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'character',
					'lang'			=> 'uc_religion',
					'image'			=> "games/cex/icons/religion/{VALUE}.png",
					'options'		=> array('' => 'uc_unknown', 1 => '1', 2 => '2',3 => '3', 4 => '4'),
					'undeletable'	=> true,
					'tolang'		=> true
				),
								'testlive'	=> array(
					'type'			=> 'radio',
					'category'		=> 'misc',
					'lang'			=> 'uc_testlive',
					'options'		=> array(0 => 'uc_no', 1 => 'uc_yes'),
					'undeletable'	=> true,
					'tolang'		=> true
				),

			);
			return $xml_fields;
		}
		protected $class_colors = array(
			0	=> '#D6F312', 	# Unknown
			1	=> '#32D6E5', 	# Tank
			2	=> '#5B933D',	# Healer
			3	=> '#800000',	# DD "maroon
			4	=> '#FF7F00', 	# Melee "orange"

		);

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;

		protected function load_filters($langs){
			if(!$this->classes) {
				$this->load_type('classes', $langs);
			}
			foreach($langs as $lang) {
				$names = $this->classes[$this->lang];
				$this->filters[$lang][] = array('name' => '-----------', 'value' => false);
				foreach($names as $id => $name) {
					$this->filters[$lang][] = array('name' => $name, 'value' => 'class:'.$id);
				}
			}
		}

		######################################################################
		##																	##
		##							EXTRA FUNCTIONS							##
		##																	##
		######################################################################

		/**
		 *	Game Settings
		 *
		 */
		public function install($install=false){
			$this->game->resetEvents();
			$arrEventIDs = array();
			$arrEventIDs[1] = $this->game->addEvent($this->glang('T1'), 0, "7206291.png");
			

			$this->game->addMultiDKPPool('Raid', 'Raids', [1], [$arrItemPools[0]]);

			//Links
			$this->game->addLink('CEX Forum', 'http://forums.conanexiles.com/');

			
			$this->game->resetRanks();
			//Ranks
			$this->game->addRank(0, "Guildmaster");
			$this->game->addRank(1, "Officer");
			$this->game->addRank(2, "Veteran");
			$this->game->addRank(3, "Member", true);
		}
		public function uninstall(){

			$this->game->removeLink("CEX Forum");

		}
	/**
	 * Per game data for the calendar Tooltip
	*/
		public function calendar_membertooltip($memberid){
			return array(
				$this->game->glang('uc_religion').': '.$this->pdh->geth('member', 'profile_field', array($memberid, 'religion', true)),

			);
		}
	}
}
?>
