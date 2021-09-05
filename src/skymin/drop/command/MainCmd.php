<?php
declare(strict_types = 1);

namespace skymin\drop\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\Player;

use skymin\drop\DropItemSetting;

use function is_null;

class MainCmd extends Command{
	
	public function __construct(private DropItemSetting $plugin){
		parent::__construct('드롭밴', 'made by skymin', '/드롭밴 [추가|초기화]', ['dropban', '드랍밴']);
		$this->setPermission('OP');
		$this->setPermissionMessage('당신은 이 명령어를 사용할 권한이 없습니다.');
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args) :void{
		if(!$sender instanceof Player){
			$sender->sendMessage('인게임에서만 사용 가능한 명령어입니다.');
			return;
		}
		if(!isset($args[0])){
			$sender->sendMessage('/드롭밴 [추가|초기화]');
			return;
		}
		if($args[0] === '추가'){
			$item = $sender->getInventory()->getItemInHand();
			if($item->isNull()){
				$sender->sendMessage('공기를 추가할 수 없습니다.');
				return;
			}
			$this->plugin->addItem($item);
			$sender->sendMessage('추가되었습니다.');
			return;
		}
		if($args[0] === '초기화'){
			$this->plugin->reset();
			$sender->sendMessage('초기화 되었습니다.');
			return;
		}
		$sender->sendMessage('/드롭밴 [추가|초기화]');
	}
	
}