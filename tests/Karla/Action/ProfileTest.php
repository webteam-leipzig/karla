<?php
use Karla\Karla;

/**
 * Profile Test file
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2014-07-15
 */
/**
 * Profile Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class ProfileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		if (! file_exists(PATH_TO_IMAGEMAGICK.'convert')) {
			$this->markTestSkipped('The imagemagick executables are not available.');
		}
	}
    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function profile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->profile('tests/_data/sRGB_Color_Space_Profile.icm')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function profileWithBuildinProfile()
    {
    	$actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in('tests/_data/demo.jpg')
    	->profile('','sRGB.icc')
    	->out('test-1920x1200.png')
    	->getCommand();
    	$expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -profile sRGB.icc "./test-1920x1200.png"';
    	$this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     * @expectedException LogicException
     *
     * @return crop
     */
    public function profileWithBothPathAndProfilenameAsArgument()
    {
    	Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in('tests/_data/demo.jpg')
    	->profile('tests/_data/sRGB_Color_Space_Profile.icm','sRGB.icc')
    	->out('test-200x200.png')
    	->getCommand();
    }
}
