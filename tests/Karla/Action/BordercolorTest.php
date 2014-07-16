<?php
use Karla\Karla;

/**
 * Bordercolor Test file
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Bordercolor Test class
 *
 * @category Test
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class BordercolorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function bordercolorWithColorName()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->bordercolor('red')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -bordercolor red "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function bordercolorTwice()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->bordercolor('red')
            ->bordercolor('red')
            ->out('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function bordercolorWithHexColor()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->bordercolor('#666666')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -bordercolor "#666666" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function bordercolorWithRgbColor()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->bordercolor('rgb(255,255,255)')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -bordercolor "rgb(255,255,255)" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function bordercolorWithInvalidColor()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->bordercolor('grenish')
            ->out('test-1920x1200.png')
            ->getCommand();
    }
}