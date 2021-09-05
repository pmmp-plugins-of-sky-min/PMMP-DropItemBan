<?php
declare(strict_types = 1);

namespace skymin\drop;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use pocketmine\item\Item;

use skymin\drop\command\MainCmd;

use function is_dir;
use function mkdir;

class DropItemSetting extends PluginBase{
	
	private Config $database;
	
	public array $db;
	
	public function onEnable() :void{
		$this->database = new Config($this->getDataFolder() . 'Config.yml', Config::YAML, ['item' => []]);
		$this->db = $this->database->getAll();
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getServer()->getCommandMap()->register('드롭밴', new MainCmd($this));
	}
	
	public function onDisable() :void{
		$this->database->setAll($this->db);
		$this->database->save();
	}
	
	public function addItem(Item $item) :void{
	  $c = $item->getCount();
	  $item->setCount(1);
		$this->db['item'][] = $item->jsonSerialize();
		$item->setCount($c);
	}
	
	public function reset() :void{
		unset($this->db['item']);
		$this->db['item'] = [];
	}
	
	public function is_Item(Item $item) :bool{
	  $c = $item->getCount();
	  $item->setCount(1);
	  $nbt = $item->jsonSerialize();
		foreach ($this->db['item'] as $key => $value){
		  if($value === $nbt){
		    return true;
		    break;
		  }
		}
		$item->setCount($c);
		return false;
	}
	
}