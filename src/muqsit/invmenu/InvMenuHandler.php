<?php

declare(strict_types=1);

namespace muqsit\invmenu;

use InvalidArgumentException;
use muqsit\invmenu\session\network\handler\PlayerNetworkHandlerRegistry;
use muqsit\invmenu\type\InvMenuTypeRegistry;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

final class InvMenuHandler{

	private static ?Plugin $registrant = null;
	private static InvMenuTypeRegistry $type_registry;

	public static function register(Plugin $plugin) : void{
		if(self::isRegistered()){
			throw new InvalidArgumentException("{$plugin->getName()} attempted to register " . self::class . " twice.");
		}

		self::$registrant = $plugin;
		self::$type_registry = new InvMenuTypeRegistry();
		PlayerNetworkHandlerRegistry::init();
		Server::getInstance()->getPluginManager()->registerEvents(new InvMenuEventHandler(), $plugin);
	}

	public static function isRegistered() : bool{
		return self::$registrant instanceof Plugin;
	}

	public static function getRegistrant() : Plugin{
		return self::$registrant;
	}

	public static function getTypeRegistry() : InvMenuTypeRegistry{
		return self::$type_registry;
	}
}