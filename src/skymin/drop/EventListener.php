<?php
declare(strict_types = 1);

namespace skymin\drop;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerDropItemEvent;

class EventListener implements Listener{
	
	public function __construct(
		private DropItemSetting $plugin
	){}
	
	public function onDrop(PlayerDropItemEvent $ev) :void{
		$player = $ev->getPlayer();
		if($player->isOp()) return;
		$item = $ev->getItem();
		if($this->plugin->is_Item($item)){
			$ev->setCancelled();
			$player->sendTip('버릴 수 없는 아이템 입니다.');
		}
	}
	
}