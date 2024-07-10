<?php

namespace wraith\critfix;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ResourcePackStackPacket;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    const CHEMISTRY_PACK_ID = "0fba4063-dba1-4281-9b89-ff9390653530";

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        var_dump($this->getServer()->getResourcePackManager()->getPackById(self::CHEMISTRY_PACK_ID));
    }

    public function onDataPacketSend(DataPacketSendEvent $event): void{
        foreach($event->getPackets() as $pk) {
            if(!$pk instanceof ResourcePackStackPacket) {
                continue;
            }

            $packStack = $pk->resourcePackStack;
            foreach($packStack as $i => $resourcePack){
                if($resourcePack->getPackId() === self::CHEMISTRY_PACK_ID) {
                    unset($packStack[$i]);
                }
            }

            $pk->resourcePackStack = $packStack;
        }
    }
}