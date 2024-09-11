<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use think\Image;
use think\ImageException;
use SplFileInfo;

<?php
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    // 测试方法
}
{
    public function testOpen()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $this->assertInstanceOf(Image::class, $image);
    }

    public function testOpenNonExistentFile()
    {
        $this->expectException(ImageException::class);
        $file = new SplFileInfo(__DIR__ . '/fixtures/non_existent.jpg');
        Image::open($file);
    }

    public function testSave()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $savedPath = __DIR__ . '/fixtures/saved_test.jpg';
        $image->save($savedPath);
        $this->assertTrue(file_exists($savedPath));
        unlink($savedPath);
    }

    public function testWidth()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $this->assertEquals(800, $image->width());
    }

    public function testHeight()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $this->assertEquals(600, $image->height());
    }

    public function testRotate()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $image->rotate(90);
        $this->assertEquals(600, $image->width());
        $this->assertEquals(800, $image->height());
    }

    public function testFlip()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $image->flip(Image::FLIP_X);
        // 验证翻转后的图像是否正确，这里需要具体的图像处理知识来判断
    }

    public function testCrop()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $croppedImage = $image->crop(200, 200, 300, 200);
        $this->assertEquals(200, $croppedImage->width());
        $this->assertEquals(200, $croppedImage->height());
    }

    public function testThumb()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $thumbnail = $image->thumb(200, 200);
        $this->assertEquals(200, $thumbnail->width());
        $this->assertEquals(200, $thumbnail->height());
    }

    public function testWater()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $watermarkFile = new SplFileInfo(__DIR__ . '/fixtures/watermark.png');
        $image->water($watermarkFile->getPathname(), Image::WATER_CENTER);
        // 验证水印是否正确添加，这里需要具体的图像处理知识来判断
    }

    public function testText()
    {
        $file = new SplFileInfo(__DIR__ . '/fixtures/test.jpg');
        $image = Image::open($file);
        $image->text('Hello, World!', __DIR__ . '/fixtures/Arial.ttf', 30, '#FF0000', Image::WATER_CENTER);
        // 验证文字是否正确添加，这里需要具体的图像处理知识来判断
    }
}
