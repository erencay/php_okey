<?
class ServerPacketHeader
{
  const ADD_TILE_TO_CUE             = 0x00;
  const APPOINT_INDICATOR           = 0x01;
  const CHANGE_STAGE                = 0x02;
  const CLAIM_A_TILE                = 0x03;
  const DISCARD_A_TILE              = 0x04;
  const DISCARDED_TILE_CLAIMED      = 0x05;
  const NEW_ROOM_FOUNDED            = 0x07;
  const PLAYER_JOINED_LOBBY         = 0x08;
  const PLAYER_LEFT_LOBBY           = 0x09;
  const READY_UP_STATUS             = 0x0A;
  const RESET_TABLE                 = 0x0B;
  const ROOM_BROKE_DOWN             = 0x0C;
  const ROOM_MESSAGE_BROADCAST      = 0x0E;
  const SCOREBOARD                  = 0x0F;
  const TABLE_OWNERSHIP_HANDED_OVER = 0x10;
  const TILE_DISCARDED              = 0x11;
  const TURN_CHANGED                = 0x12;
  const UPDATE_MY_DATA              = 0x13;
  const UPDATE_ROOM_SEAT            = 0x14;
  const UPDATE_ROOM_SETTING         = 0x15;
  const UPDATE_TABLE_SEAT           = 0x16;
  const UPDATE_TILES_LEFT           = 0x17;
  const UPDATE_VIEWPORT             = 0x18;
  const UPDATE_TABLE_SETTING        = 0x1C;
  const SYSTEM_MESSAGE              = 0x1E;
  const RESET_LOBBY                 = 0x1F;
  const TABLE_SEAT_TAKEN            = 0x20;
  const TABLE_SEAT_DUMPED           = 0x21;
  const ROOM_SEAT_TAKEN             = 0x22;
  const ROOM_SEAT_DUMPED            = 0x23;
  const REMOVE_TILE_FROM_CUE        = 0x24;
  const GAME_STARTED                = 0x25;
  const GAME_SUSPENDED              = 0x26;
  const GAME_IS_RESUMING            = 0x27;
  const GAME_OVER                   = 0x28;
}

