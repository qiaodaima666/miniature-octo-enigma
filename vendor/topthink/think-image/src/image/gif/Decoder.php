public function readDescriptor()
{
    $this->getByte(9);
    $gifScreen = $this->gifBuffer;
    $gifColorF = $this->gifBuffer[8] & 0x80 ? 1 : 0;
    
    if ($gifColorF) {
        $this->processLocalColorTable();
    } else {
        $this->useGlobalColorTable();
    }
    
    $this->updateScreenProperties($gifScreen);
    $this->buildImageString($gifScreen);
}

private function processLocalColorTable()
{
    $gifCode = $this->gifBuffer[8] & 0x07;
    $gifSort = $this->gifBuffer[8] & 0x20 ? 1 : 0;
    $gifSize = 2 << $gifCode;
    $this->getByte(3 * $gifSize);
    $this->putByte($this->gifBuffer);
}

private function useGlobalColorTable()
{
    $this->putByte($this->gifGlobal);
}

private function updateScreenProperties($gifScreen)
{
    $this->gifScreen[4] &= 0x70;
    $this->gifScreen[4] |= 0x80;
    $this->gifScreen[4] |= $this->gifColorC;
    if ($this->gifSorted) {
        $this->gifScreen[4] |= 0x08;
    }
}

private function buildImageString($gifScreen)
{
    $this->gifString = "GIF87a";
    $this->putByte($this->gifScreen);
    $this->putByte(chr(0x2C));
    $this->putByte($gifScreen);
    $this->getByte(1);
    $this->putByte($this->gifBuffer);
    
    while (true) {
        $this->getByte(1);
        $this->putByte($this->gifBuffer);
        if (($u = $this->gifBuffer[0]) == 0x00) {
            break;
        }
        $this->getByte($u);
        $this->putByte($this->gifBuffer);
    }
    
    $this->gifString .= chr(0x3B);
    $this->gifArrays[] = $this->gifString;
}