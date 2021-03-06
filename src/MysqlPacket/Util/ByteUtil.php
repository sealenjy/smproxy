<?php
namespace  SMProxy\MysqlPacket\Util;

use SMProxy\MysqlPacket\MySQLMessage;

/**
 * Author: Louis Livi <574747417@qq.com>
 * Date: 2018/10/27
 * Time: 上午10:44
 */
class ByteUtil
{
    static public function readUB2($data)
    {
        $i = ($data[0] );
        $i |= ($data[1]  << 8);
        return $i;
    }

    static public function readUB3($data)
    {
        $i = ($data[0] );
        $i |= ($data[1]  << 8);
        $i |= ($data[2]  << 16);
        return $i;
    }

    static public function readUB4($data)
    {
        $i = ($data[0] );
        $i |= ($data[1]  << 8);
        $i |= ($data[2]  << 16);
        $i |= ($data[3]  << 24);
        return $i;
    }

    static public function readLong($data)
    {
        $l = ($data[0] );
        $l |= ($data[1] ) << 8;
        $l |= ($data[2] ) << 16;
        $l |= ($data[3] ) << 24;
        $l |= ($data[4] ) << 32;
        $l |= ($data[5] ) << 40;
        $l |= ($data[6] ) << 48;
        $l |= ($data[7] ) << 56;
        return $l;
    }

    /**
     * this is for the String
     *
     * @param $data
     *
     * @return
     */
    static public function readLength($data)
    {
        $length = $data[0] ;
        switch ($length) {
            case 251:
                return MySQLMessage::$NULL_LENGTH;
            case 252:
                return self::readUB2($data);
            case 253:
                return self::readUB3($data);
            case 254:
                return self::readLong($data);
            default:
                return $length;
        }
    }


    static public function decodeLength($src)
    {
        if (is_array($src)) {
            $length = count($src);
            if ($length < 251) {
                return 1 + $length;
            } else if ($length < 0x10000) {
                return 3 + $length;
            } else if ($length < 0x1000000) {
                return 4 + $length;
            } else {
                return 9 + $length;
            }
        } else {
            if ($src < 251) {
                return 1;
            } else if ($src < 0x10000) {
                return 3;
            } else if ($src < 0x1000000) {
                return 4;
            } else {
                return 9;
            }
        }

    }

}