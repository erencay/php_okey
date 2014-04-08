<?
define('MMOCORE_VERSION_ID', '0.1');

require 'exception/MMOException.php';
require 'exception/SimpleByteArrayException.php';
require 'util/Utils.php';
require 'util/SimpleByteArray.php';
require 'util/Logger.php';
require 'network/MMOClient.php';
require 'network/MMOServer.php';
require 'network/MMOPacketHandlerInterface.php';
require 'network/MMOPacketAbstract.php';
require 'network/MMOReceivablePacket.php';
require 'network/MMOSendablePacket.php';