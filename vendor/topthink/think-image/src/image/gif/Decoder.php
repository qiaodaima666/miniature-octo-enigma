<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\image\gif;

class Decoder
{
    private $gifBuffer = [];
    private $gifArrays = [];
    private $gifDelays = [];
    private $gifStream = "";
    private $gifString = "";
    private $gifBfseek = 0;
    private $gifScreen = [];
    private $gifGlobal = [];
    private $gifSorted;
    private $gifColorS;
    private $gifColorC;
    private $gifColorF;

    /**
     * GIFDecoder constructor.
     * @param string $gifPointer
     */
    public function __construct(string $gifPointer)
    {
        $this->gifStream = $gifPointer;
        $this->getByte(6); // GIF89a
        $this->getByte(7); // Logical Screen Descriptor
        $this->gifScreen = $this->gifBuffer;
        $this->gifColorF = $this->gifBuffer[4] & 0x80 ? 1 : 0;
        $this->gifSorted = $this->gifBuffer[4] & 0x08 ? 1 : 0;
        $this->gifColorC = $this->gifBuffer[4] & 0x07;
        $this->gifColorS = 2 << $this->gifColorC;
        if (1 == $this->gifColorF) {
            $this->getByte(3 * $this->gifColorS);
            $this->gifGlobal = $this->gifBuffer;
        }

        for ($cycle = 1; $cycle;) {
            if ($this->getByte(1)) {
                switch ($this->gifBuffer[0]) {
                    case 0x21:
                        $this->readExtensions();
                        break;
                    case 0x2C:
                        $this->readDescriptor();
                        break;
                    case 0x3B:
                        $cycle = 0;
                        break;
                }
            } else {
                $cycle = 0;
            }
        }
    }

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::    GIFReadExtension ( )
    ::
     */
    public function readExtensions()
    {
        $this->getByte(1);
        for (; ;) {
            $this->getByte(1);
            if (($u = $this->gifBuffer[0]) == 0x00) {
                break;
            }
            $this->getByte($u);
            /*
             * 07.05.2007.
             * Implemented a new line for a new function
             * to determine the originaly delays between
             * frames.
             *
             */
            if (4 == $u) {
                $this->gifDelays[] = ($this->gifBuffer[1] | $this->gifBuffer[2] << 8);
            }
        }
    }

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::    GIFReadExtension ( )
    ::
     */
    public function readDescriptor()
    {
        $this->getByte(9);
        $gifScreen = $this->gifBuffer;
        $gifColorF = $this->gifBuffer[8] & 0x80 ? 1 : 0;
        if ($gifColorF) {
            $gifCode = $this->gifBuffer[8] & 0x07;
            $gifSort = $this->gifBuffer[8] & 0x20 ? 1 : 0;
        } else {
            $gifCode = $this->gifColorC;
            $gifSort = $this->gifSorted;
        }
        $gifSize = 2 << $gifCode;
        $this->gifScreen[4] &= 0x70;
        $this->gifScreen[4] |= 0x80;
        $this->gifScreen[4] |= $gifCode;
        if ($gifSort) {
            $this->gifScreen[4] |= 0x08;
        }
        $this->gifString = "GIF87a";
        $this->putByte($this->gifScreen);
        if (1 == $gifColorF) {
            $this->getByte(3 * $gifSize);
            $this->putByte($this->gifBuffer);
        } else {
            $this->putByte($this->gifGlobal);
        }
        $this->gifString .= chr(0x2C);
        $gifScreen[8] &= 0x40;
        $this->putByte($gifScreen);
        $this->getByte(1);
        $this->putByte($this->gifBuffer);
        for (; ;) {
            $this->getByte(1);
            $this->putByte($this->gifBuffer);
            if (($u = $this->gifBuffer[0]) == 0x00) {
                break;
            }
            $this->getByte($u);
            $this->putByte($this->gifBuffer);
        }
        $this->gifString .= chr(0x3B);
        /*
        Add frames into $gifStream array...
         */
        $this->gifArrays[] = $this->gifString;
    }

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::    GIFGetByte ( $len )
    ::
    */
    public function getByte($len)
    {
        $this->gifBuffer = [];
        for ($i = 0; $i < $len; $i++) {
            if ($this->gifBfseek > strlen($this->gifStream)) {
                return 0;
            }
            $this->gifBuffer[] = ord($this->gifStream{$this->gifBfseek++});
        }
        return 1;
    }

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::    GIFPutByte ( $bytes )
    ::
     */
    public function putByte($bytes)
    {
        for ($i = 0; $i < count($bytes); $i++) {
            $this->gifString .= chr($bytes[$i]);
        }
    }

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::    PUBLIC FUNCTIONS
    ::
    ::
    ::    GIFGetFrames ( )
    ::
     */
    public function getFrames()
    {
        return ($this->gifArrays);
    }

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::    GIFGetDelays ( )
    ::
     */
    public function getDelays()
    {
        return ($this->gifDelays);
    }
}