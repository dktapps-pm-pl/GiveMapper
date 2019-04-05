<?php

declare(strict_types=1);

namespace dktapps\GiveMapper;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\GiveCommand;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\plugin\PluginBase;
use function fclose;
use function json_decode;
use function stream_get_contents;

class Main extends PluginBase{

	public function onEnable() : void{
		$res = $this->getResource("fake_ids.json");
		$nameMap = json_decode(stream_get_contents($res), true);
		fclose($res);

		$map = $this->getServer()->getCommandMap();
		$give = $map->getCommand("give");
		$map->unregister($give);
		$map->register("pocketmine", new class($give, $nameMap) extends Command{
			/** @var GiveCommand */
			private $delegate;
			/** @var string[] */
			private $mappings;

			public function __construct(GiveCommand $delegate, array $mappings){
				$this->delegate = $delegate;
				$this->mappings = $mappings;
				parent::__construct($delegate->getName(), $delegate->getDescription(), $delegate->getUsage(), $delegate->getAliases());
				$this->setPermission($delegate->getPermission());
			}

			public function execute(CommandSender $sender, string $commandLabel, array $args){
				if(!isset($args[1])){
					throw new InvalidCommandSyntaxException;
				}
				if(isset($this->mappings[$args[1]])){
					$args[1] = $this->mappings[$args[1]];
				}
				$this->delegate->execute($sender, $commandLabel, $args);
			}
		});
	}
}
