<?php

namespace NewmoomCat\moreCommands;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\ulits\TextFormat;

class Main extends PluginBase{

	private $gamerules = [
		"KeepInventory" => false,
	];

	public function onEnable(){
		$this->getLogger()->info("用于添加更多原版指令的插件");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if(count($args) === 0) {
			foreach ($this->gamerules as $rule => $value) {
				$sender->sendMessage(TextFormat::GREEN . $rule . ": " . ($value ? "Enabled" : "Disabled"));
			}
			return true;
		}
		$rule = strotolower($args[0]);
		if(!array_key_exists($rule, $this->gamerules)) {
			$sender->sendMessage(TextFormat::RED ."该Gamerule未被添加，请联系作者");
			return false;
		}

		if(count($args) === 1) {
			$sender->sendMessage(TextFormat::GREEN . $rule .": " . ($this->gamerules[$rule] ? "Enabled" : "Disabled"));
			return true;
		}

		$value = strtolower($args[1]);
		if($value === "true" || $value === "1") {
			$this->gamerules[$rule] = true;
			$sender->sendMessage(TextFormat::GREEN . "已启用");
		} elseif ($value === "false" || $value === "0") {
			$this->gamerules[$rule] = false;
			$sender->sendMessage(TextFormat::RED ."已禁用");
		} else {
			$sender->sendMessage(TextFormat::GREEN ."该值无效，请使用正确值");
			return false;
		}

		return true;
	}

	public function onDisable(){
		$this->getLogger()->info("插件已经关闭");
	}
}