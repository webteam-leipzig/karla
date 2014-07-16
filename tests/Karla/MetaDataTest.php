<?php
use Karla\Karla;

/**
 * MetaData Test file
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-11
 */
/**
 * MetaData Test class
 *
 * @category Test
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class MetaDataTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Meta data obejct
     *
     * @var MetaData
     */
    protected $object;

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->object = null;
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getResolutionHeight()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getResolutionHeightVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(300, $this->object->getResolutionHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getResolutionWidthVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(300, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getResolutionWidth()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function parseMethods()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function parseMethodsVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->verbose()
            ->execute(true, false);
        $this->assertEquals(300, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getFormatVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('jpeg', $this->object->getFormat());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getFormat()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('jpeg', $this->object->getFormat());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getDepthVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(8, $this->object->getDepth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getDepth()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(8, $this->object->getDepth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getColorspaceVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('srgb', $this->object->getColorspace());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getColorspace()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('srgb', $this->object->getColorspace());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getGeometryVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertArrayHasKey(0, $this->object->getGeometry());
        $this->assertArrayHasKey(1, $this->object->getGeometry());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getGeometry()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertArrayHasKey(0, $this->object->getGeometry());
        $this->assertArrayHasKey(1, $this->object->getGeometry());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getHeightVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(155, $this->object->getHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getHeight()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(155, $this->object->getHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getWidthVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(200, $this->object->getWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getWidth()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(200, $this->object->getWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function listRawVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertStringStartsWith('<ul>', $this->object->listRaw());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function listRaw()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertStringStartsWith('<ul>', $this->object->listRaw());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getUnitVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('Pixels Per Inch', $this->object->getUnit());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getUnit()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('Pixels Per Inch', $this->object->getUnit());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getHashVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('b48a66ad34a1942857d8b22325ac9898', $this->object->getHash());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getHash()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('b48a66ad34a1942857d8b22325ac9898', $this->object->getHash());
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function getHashWithInvalidAlgorithm()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->object->getHash('sha');
    }
}
