<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.0.0
 */
 
const stats = [
	3 => [
		'type' => 'agility',
		'prize' => 10,
		'amount' => 10000
	],
	4 => [
		'type' => 'strength',
		'prize' => 10,
		'amount' => 10000
	],
	5 => [
		'type' => 'intellect',
		'prize' => 10,
		'amount' => 10000
	],
	6 => [
		'type' => 'spirit',
		'prize' => 10,
		'amount' => 10000
	],
	7 => [
		'type' => 'stamina',
		'prize' => 10,
		'amount' => 10000
	],
	12 => [
		'type' => 'defense',
		'prize' => 10,
		'amount' => 300
	],
	13 => [
		'type' => 'dodge',
		'prize' => 10,
		'amount' => 300
	],
	14 => [
		'type' => 'parry',
		'prize' => 10,
		'amount' => 300
	],
	15 => [
		'type' => 'block',
		'prize' => 10,
		'amount' => 300
	],
	31 => [
		'type' => 'hit',
		'prize' => 10,
		'amount' => 300
	],
	32 => [
		'type' => 'crit',
		'prize' => 10,
		'amount' => 300
	],
	35 => [
		'type' => 'resilience',
		'prize' => 10,
		'amount' => 100
	],
	36 => [
		'type' => 'haste',
		'prize' => 10,
		'amount' => 1500
	],
	37 => [
		'type' => 'expertise',
		'prize' => 10,
		'amount' => 300
	],
	38 => [
		'type' => 'attack-power',
		'prize' => 10,
		'amount' => 20000
	],
	44 => [
		'type' => 'armor-pen',
		'prize' => 10,
		'amount' => 500
	],
	45 => [
		'type' => 'spell-power',
		'prize' => 10,
		'amount' => 20000
	],
	47 => [
		'type' => 'spell-pen',
		'prize' => 10,
		'amount' => 50
	],
	'A' => [
		'type' => 'weapon-dmg',
		'prize' => 10,
		'amount' => 10000
	],
	'B' => [
		'type' => 'weapon-spe',
		'prize' => 15,
		'amount' => 0.5
	],
	'C' => [
		'type' => 'reg-gem',
		'prize' => 2,
		'amount' => 1
	],
	'D' => [
		'type' => 'meta-gem',
		'prize' => 10,
		'amount' => 1
	],
	'E' =>[
		'type' => 'accountbound',
		'prize' => 20,
		'amount' => 1
	],
	'F' =>[
		'type' => 'armor',
		'amount' => 2000,
		'prize' => 10
	],
	'G' =>[
		'type' => 'magic-res',
		'amount' => 25,
		'prize' => 10
	]
];

const colors = [
	'red' => 'FF0000',
	'lime' => '00FF00',
	'blue' => '0000FF',
	'orange' => 'FFA500',
	'green' => '008000',
	'purple' => '800080',
	'gold' => 'FFD700',
	'cyan' => '00FFFF',
	'sky-blue' => '87CEFA',
	'silver' => 'C0C0C0',
	'white' => 'FFFFFF'
];

const cItemsColumns = 'entry, class, subclass, name, displayid, InventoryType, StatsCount, stat_type1, stat_value1, stat_type2, stat_value2, stat_type3, stat_value3, stat_type4, stat_value4, stat_type5, stat_value5, stat_type6, stat_value6, stat_type7, stat_value7, stat_type8, stat_value8, stat_type9, stat_value9, stat_type10, stat_value10, dmg_min1, dmg_max1, delay, sheath, socketColor_1, socketColor_2, socketColor_3, Flags, quality, holy_res, fire_res, nature_res, arcane_res, frost_res, shadow_res, armor';
const cItemsWhereClause = '(`name` LIKE "VIP _ %" OR `name` LIKE "VIP _.5 %" OR `name` LIKE "Donor %") AND `name` NOT LIKE "VIP _ Haste GEM" and `name` NOT LIKE "V__ 9 %"';

const cItemTable = [
	'tableName' => 'item_battleground_lock',
	'entryColumn' => 'Item_entry'
];

const itemReloadCmd = 'reload_item_template';

const statValueMax = 8388607;

const entryMin = 16000300;

const keepItem = ['prize' => 10];

const mainStatCap = 1000000;
const hasteCap = 32767;
const resilienceCap = 800;
const weaponDamageCap = 1000000; #dmg_max1
const magicResCap = 250;
const weaponSpeedCap = 3.0; #1h+dagger
const weaponSpeed2hCap = 4.0; #bows+2h+guns+polearm
