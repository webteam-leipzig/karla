<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Class for wrapping ImageMagicks convert tool
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class Convert extends ImageMagick
{
	/**
	 * Output option
	 * @var Array
	 */
	protected $outputOptions;

	/**
	 * Input file
	 * @var string
	 */
	protected $inputFile;
	/**
	 * Output file
	 * @var string
	 */
	protected $outputFile;

	/**
	 * Add input argument
	 *
	 * @param string $filePath Input file path
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 */
	public function inputfile($filePath)
	{
		if (!file_exists($filePath)) {
			$message = 'The input file path (' .
			$filePath . ') is invalid or the file could not be located.';
			throw new InvalidArgumentException($message);
		}
		$file = new SplFileObject($filePath);
		if ($file->isReadable()) {
			$this->inputFile = '"' . $file->getPathname() . '"';
		}
		$this->dirty();
		return $this;
	}
	/**
	 * Add output argument
	 *
	 * @param string  $filePath       Output file path
	 * @param boolean $includeOptions Include the used options as part of the filename
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 */
	public function outputfile($filePath, $includeOptions = true)
	{
		$pathinfo = pathinfo($filePath);
		if (!file_exists($pathinfo['dirname'])) {
			$message = 'The output file path (' . $pathinfo['dirname'] .
                       ') is invalid or could not be located.';
			throw new InvalidArgumentException($message);
		}
		$file = new SplFileObject($pathinfo['dirname']);
		if (!$file->isWritable()) {
			$message = 'The output file path (' . $pathinfo['dirname'] .
                       ') is not writable.';
			throw new InvalidArgumentException($message);
		}
		$this->outputFile = '"' . $file->getPathname() . '/' . $pathinfo['basename'] . '"';
		$this->dirty();
		return $this;
	}

	/**
	 * Add a background color to a image
	 *
	 * @param string $color Color
	 *
	 * @return Convert
	 * @throws BadMethodCallException if background has already been called
	 */
	public function background($color)
	{
		if ($this->isOptionSet('background', $this->inputOptions)) {
			throw new BadMethodCallException('Background can only be called once.');
		}
		$this->inputOptions[] = ' -background "' .  $color. '"';
		$this->dirty();
		return $this;
	}

	/**
	 * Remove a profile from the image.
	 *
	 * @param string $profileName Profile name
	 *
	 * @return Convert
	 *
	 * @todo get list of profiles from image (can be done by identify but might be to expsensive)
	 */
	public function removeProfile($profileName)
	{
		$this->inputOptions[] = " +profile " . $profileName;
		$this->dirty();
		return $this;
	}

	/**
	 * Resample the image to a new resolution
	 *
	 * @param integer $newWidth       New image resolution
	 * @param integer $newHeight      New image resolution
	 * @param integer $originalWidth  Original image resolution
	 * @param integer $originalHeight Original image resolution
	 *
	 * @return Convert
	 * @throws BadMethodCallException if resample, resize or density has already been called
	 * @throws InvalidArgumentException
	 */
	public function resample($newWidth, $newHeight = "", $originalWidth = "", $originalHeight = "")
	{
		if ($this->isOptionSet('resample', $this->inputOptions)) {
			throw new BadMethodCallException('resample can only be called once.');
		}
		if ($this->isOptionSet('resize', $this->inputOptions)) {
			throw new BadMethodCallException('You may not use resample option with resize option');
		}
		if ($this->isOptionSet('density', $this->inputOptions)) {
			throw new BadMethodCallException('You may not use resample option with density option');
		}
		if (!is_numeric($newWidth)) {
			$message = 'You must supply new width as a integer.
                        Was (' . $newWidth . ')';
			throw new InvalidArgumentException($message);
		}
		if ($newHeight != '' && !is_numeric($newHeight)) {
			$message = 'You must supply new height as a integer or as an empty string.
                        Was (' . $newHeight . ')';
			throw new InvalidArgumentException($message);
		}
		if ($originalWidth != '' && !is_numeric($originalWidth)) {
			$message = 'You must supply original width as a integer or as an empty string.
                        Was (' . $originalWidth . ')';
			throw new InvalidArgumentException($message);
		}
		if ($originalHeight != '' && !is_numeric($originalHeight)) {
			$message = 'You must supply original height as a integer or as an empty string.
                        Was (' . $originalHeight . ')';
			throw new InvalidArgumentException($message);
		}

		if ($originalWidth != "" && $originalHeight != "") {
			$this->density($originalWidth, $originalHeight);
		}
		if ($originalWidth != "" && $originalHeight == "") {
			$this->density($originalWidth, $originalWidth);
		}
		$option = " -resample '";
		if ($newWidth != "" && $newHeight != "") {
			$option = $option . $newWidth . "x" . $newHeight;
		} elseif ($newWidth != "") {
			$option = $option . $newWidth;
		}
		$option = $option . "' ";
		$this->inputOptions[] = $option;
		$this->dirty();
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see lib/Imagemagick#getCommand()
	 * @return string
	 */
	public function getCommandOld()
	{
		if ($this->outputFile == '') {
			throw new RuntimeException('Can not preform convert without an output file');
		}
		!is_array($this->outputOptions) ? $this->outputOptions = array() : null;
		!is_array($this->inputOptions) ? $this->inputOptions = array() : null;
		$inputFile = ' ' . $this->inputFile . ' ';
		$outputFile = ' ' . $this->outputFile . ' ';

		return
		$this->binPath.$this->bin.' '.
		$this->prepareOptions($this->inputOptions).' '.
		$inputFile.' '.
		$this->prepareOptions($this->outputOptions).' '.
		$outputFile;
	}


	/**
	 * (non-PHPdoc)
	 *
	 * @see lib/Imagemagick#getCommand()
	 * @return string
	 */
	public function getCommand()
	{
		if ($this->outputFile == '') {
			throw new RuntimeException('Can not perform convert without an output file');
		}
		if ($this->inputFile == '') {
			throw new RuntimeException('Can not perform convert without an input file');
		}
		
		!is_array($this->outputOptions) ? $this->outputOptions = array() : null;
		!is_array($this->inputOptions) ? $this->inputOptions = array() : null;
		$inOptions = $this->prepareOptions($this->inputOptions) == '' ? '' : $this->prepareOptions($this->inputOptions).' ';
		$outOptions = $this->prepareOptions($this->outputOptions) == '' ? '' : $this->prepareOptions($this->outputOptions).' ';

		return $this->binPath.$this->bin . ' ' . $inOptions . $this->inputFile . ' ' .$outOptions . $this->outputFile;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see lib/Imagemagick#reset()
	 * @return void
	 */
	public function reset()
	{
		$this->outputOptions = array();
		$this->inputFile = '';
		$this->outputFile = '';
		parent::reset();
	}
	/**
	 * (non-PHPdoc)
	 *
	 * @see lib/Imagemagick#execute()
	 *
	 * @return string
	 */
	public function execute()
	{
		if ($this->cache instanceof Cache) {
			!is_array($this->inputOptions) ? $this->inputOptions = array() : null;
			if ($this->cache->isCached($this->inputFile, $this->inputOptions)) {
				return $this->cache->getCached($this->inputFile, $this->inputOptions);
			} else {
				$this->outputFile = $this->cache->setCache($this->inputFile, $this->inputOptions);
			}
		} else {
			$temp = $this->outputFile;
			parent::execute();
			//For some reason php's chmod can't see the file
			shell_exec('chmod 666 ' . $temp);
			return $this->outputFile;
		}
	}

	/**
	 * Size the input image
	 *
	 * @param integer $width  Image width
	 * @param integer $height Image height
	 *
	 * @return Convert
	 * @throws BadMethodCallException if size has already been called
	 * @throws InvalidArgumentException
	 */
	public function size($width = "", $height = "")
	{
		if ($this->isOptionSet('size', $this->inputOptions)) {
			throw new BadMethodCallException('Size can only be called once.');
		}
		if ($width == "" && $height == "") {
			$message = 'You must supply height or width or both to size the image';
			throw new InvalidArgumentException($message);
		}
		$option = " -size ";

		$option = $option . $width . "x" . $height;

		$option = $option . " ";
		$this->inputOptions[] = $option;
		$this->dirty();
		return $this;
	}

	/**
	 * Set the density of the output image.
	 *
	 * @param integer $width  The width of the image
	 * @param integer $height The height of the image
	 *
	 * @return Convert
	 * @throws BadMethodCallException if density has already been called
	 * @throws InvalidArgumentException
	 */
	public function density($width = 72, $height = 72)
	{
		if ($this->isOptionSet('density', $this->inputOptions)) {
			$message = "'density()' can only be called once.";
			throw new BadMethodCallException($message);
		}
		if (!is_numeric($width)) {
			$message = 'Width must be numeric values in the density method';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($width)) {
			$message = 'Height must be numeric values in the density method';
			throw new InvalidArgumentException($message);
		}
		$this->inputOptions[] = " -density " . $width . "x" . $height;
		$this->dirty();
		return $this;
	}

	/**
	 * Flatten layers in an image.
	 *
	 * @param boolean $flatten Flatten the image; default is true.
	 *
	 * @return Convert
	 * @throws BadMethodCallException if flatten has already been called
	 * @throws InvalidArgumentException
	 */
	public function flatten($flatten = true)
	{
		if ($this->isOptionSet('flatten', $this->inputOptions)) {
			$message = "'flatte()' can only be called once.";
			throw new BadMethodCallException($message);
		}
		if (!is_bool($flatten)) {
			$message = 'Flatten only accepts a boolean value';
			throw new InvalidArgumentException($message);
		}
		$this->inputOptions[] = " -flatten ";
		$this->dirty();
		return $this;
	}

	/**
	 * Strip image of any profiles or comments.
	 *
	 * @param boolean $strip - Should strip be used; default is true.
	 *
	 * @return Convert
	 * @throws BadMethodCallException if strip has already been called
	 * @throws InvalidArgumentException
	 */
	public function strip($strip = true)
	{
		if ($this->isOptionSet('strip', $this->inputOptions)) {
			$message = "'strip()' can only be called once.";
			throw new BadMethodCallException($message);
		}
		if (!is_bool($strip)) {
			$message = 'Strip only accepts a boolean value';
			throw new InvalidArgumentException($message);
		}
		$this->inputOptions[] = " -strip ";
		$this->dirty();
		return $this;
	}
	/**
	 * Flip image
	 *
	 * @return Convert
	 * @throws BadMethodCallException if strip has already been called
	 */
	public function flip()
	{
		if ($this->isOptionSet('flip', $this->inputOptions)) {
			$message = "'flip()' can only be called once.";
			throw new BadMethodCallException($message);
		}
		$this->inputOptions[] = " -flip ";
		$this->dirty();
		return $this;
	}
	/**
	 * Flop image
	 *
	 * @return Convert
	 * @throws BadMethodCallException if strip has already been called
	 */
	public function flop()
	{
		if ($this->isOptionSet('flop', $this->inputOptions)) {
			$message = "'flop()' can only be called once.";
			throw new BadMethodCallException($message);
		}
		$this->inputOptions[] = " -flop ";
		$this->dirty();
		return $this;
	}
	
	
	
	/**
	 * Set output image type
	 *
	 * @param string $type The output image type
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if type has already been called
	 */
	public function type($type)
	{
		if ($this->isOptionSet('type', $this->outputOptions)) {
			$message = "'type()' can only be called once.";
			throw new BadMethodCallException($message);
		}
		if (!$this->supportedImageTypes($type)) {
			$message = 'The supplied colorspace (' .
					$type . ') is not supported by imagemagick';
			throw new InvalidArgumentException($message);
		}
		$this->inputOptions[] = " -type ".$type.' ';
		$this->dirty();
		return $this;
	}

	/**
	 * Add a profile to the image.
	 *
	 * @param string $profilePath Path to the profile
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 */
	public function profile($profilePath)
	{
		if (!file_exists($profilePath)) {
			$message = 'Could not add profile as input file (' .
			$profilePath . ') could not be found.';
			throw new InvalidArgumentException($message);
		}
		$this->outputOptions[] = ' -profile "' . $profilePath . '" ';
		$this->dirty();
		return $this;
	}

	/**
	 * Change profile on the image.
	 *
	 * @param string $profilePathFrom Path to the profile
	 * @param string $profilePathTo   Path to the profile
	 *
	 * @return Convert
	 * @throws BadMethodCallException if changeprofile has already been called
	 * @throws InvalidArgumentException
	 */
	public function changeProfile($profilePathFrom, $profilePathTo)
	{
		if ($this->isOptionSet('profile', $this->outputOptions)) {
			$message = "'changeProfile()' can only be called once and not at the same time as 'profile()'.";
			throw new BadMethodCallException($message);
		}
		if (!file_exists($profilePathFrom)) {
			$message = 'Could not add input profile as input file (' .
			$profilePath . ') could not be found.';
			throw new InvalidArgumentException($message);
		}
		if (!file_exists($profilePathTo)) {
			$message = 'Could not add output profile as input file (' .
			$profilePath . ') could not be found.';
			throw new InvalidArgumentException($message);
		}
		$this->profile($profilePathFrom);
		$this->profile($profilePathTo);
		return $this;
	}

	/**
	 * Apply a method to layers in images.
	 *
	 * @param string $method The method to use
	 *
	 * @return Convert
	 * @throws InvalidArgumentException if the layer method wasn't recognized
	 */
	public function layers($method)
	{
		if (!$this->supportedLayerMethod($method)) {
			$message = 'Tried to apply unknown method to layers';
			throw new InvalidArgumentException($message);
		}
		$this->inputOptions[] = " -layers " . $method;
		$this->dirty();
		return $this;
	}

	/**
	 * Resize the input image
	 *
	 * @param integer $width               Image width
	 * @param integer $height              Image height
	 * @param boolean $maintainAspectRatio Should we maintain aspect ratio? default is true
	 * @param boolean $dontScaleUp         Should we prohipped scaling up? default is true
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if resize has already been called
	 */
	public function resize($width = "", $height = "", $maintainAspectRatio = true, $dontScaleUp = true)
	{
		if ($this->isOptionSet('resize', $this->inputOptions)) {
			throw new BadMethodCallException('resize can only be called once.');
		}
		if ($width == "" && $height == "") {
			$message = 'You must supply height or width or both to resize the image';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($width) && $width != '') {
			$message = 'width must be an integer value or empty.';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($height) && $height != '') {
			$message = 'height must be an integer value or empty.';
			throw new InvalidArgumentException($message);
		}

		$option = " -resize ";

		if ($width != '') {
			$option = $option . $width;
		}

		if ($height != '') {
			$option = $option . "x" . $height;
		}

		if (!$maintainAspectRatio) {
			$option = $option . "!";
		}
		if ($dontScaleUp) {
			$option = $option . "\>";
		}
		$option = $option . " ";
		$this->inputOptions[] = $option;
		$this->dirty();
		return $this;
	}

	/**
	 * Resize the input image
	 *
	 * @param integer $width   Image width
	 * @param integer $height  Image height
	 * @param integer $xOffset X offset from upper-left corner
	 * @param integer $yOffset Y offset from upper-left corner
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if crop has already been called
	 */
	public function crop($width, $height, $xOffset = 0, $yOffset = 0)
	{
		if ($this->isOptionSet('crop', $this->inputOptions)) {
			throw new BadMethodCallException('crop can only be called once.');
		}
		if ($width == "" || $height == "") {
			$message = 'You must supply height and width to crop the image';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($width) && $width != '') {
			$message = 'width must be an integer value or empty.';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($height) && $height != '') {
			$message = 'height must be an integer value or empty.';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($xOffset)) {
			$message = 'xOffset must be an integer value.';
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($yOffset)) {
			$message = 'yOffset must be an integer value.';
			throw new InvalidArgumentException($message);
		}

		$option = " -crop " . $width ."x" . $height;

		if ($xOffset >= 0) {
			$option = $option . "+".$xOffset;
		} else {
			$option = $option . $xOffset;
		}

		if ($yOffset >= 0) {
			$option = $option . "+".$yOffset;
		} else {
			$option = $option . $yOffset;
		}

		//http://www.imagemagick.org/Usage/crop/#crop_repage
		$option = $option . " +repage ";
		$this->inputOptions[] = $option;
		$this->dirty();
		return $this;
	}

	/**
	 * Set the quality of the output image for jpeg an png.
	 *
	 * @param integer $quality A value between 0 - 100
	 * @param string  $format  Format to use; default is jpeg
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if quality has already been called
	 * @throws RangeException if quality is not a value between 0 - 100
	 */
	public function quality($quality, $format = 'jpeg')
	{
		if ($this->isOptionSet('quality', $this->inputOptions)) {
			throw new BadMethodCallException("'quality()' can only be called once.");
		}
		if (!$this->supportedFormat($format) && ($format != 'jpeg' || $format != 'jpg' || $format != 'png')) {
			$message = "'quality()' is only supported for the jpeg and png format. Used (".$format.")";
			throw new InvalidArgumentException($message);
		}
		if (!is_numeric($quality)) {
			$message = "quality argument must be an integer value. Used (".$quality.")";
			throw new InvalidArgumentException($message);
		}
		if (!($quality >= 0 && $quality <= 100)) {
			$message = "quality argument must be between 0 and 100 both inclusive. Used (".$quality.")";
			throw new RangeException($message);
		}
		$this->inputOptions[] = " -quality " . $quality;
		$this->dirty();
		return $this;
	}

	/**
	 * Set the gravity
	 *
	 * (This method is only redefined to support autocompletion in ide's like Eclipse)
	 *
	 * @param string $gravity Gravity
	 *
	 * @return Convert
	 */
	public function gravity($gravity)
	{
		return parent::gravity($gravity);
	}

	/**
	 * Set the colorspace for the image
	 *
	 * @param string $colorSpace The colorspace to use
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if colorspace has already been called
	 */
	public function colorspace($colorSpace)
	{
		if ($this->isOptionSet('colorspace', $this->outputOptions)) {
			throw new BadMethodCallException('Colorspace can only be called once.');
		}
		if (!$this->supportedColorSpace($colorSpace)) {
			$message = 'The supplied colorspace (' .
			$colorSpace . ') is not supported by imagemagick';
			throw new InvalidArgumentException($message);
		}
		$this->outputOptions[] = " -colorspace " . $colorSpace . ' ';
		$this->dirty();
		return $this;
	}
	/**
	 * Sepia tone the image
	 *
	 * @param string $threshold The threshold to use
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if sepia has already been called
	 */
	public function sepia($threshold = 80)
	{
		if ($this->isOptionSet('sepia-tone', $this->outputOptions)) {
			throw new BadMethodCallException('Sepia can only be called once.');
		}
		if (!is_integer($threshold)) {
			$message = 'The supplied threshold (' .
			$threshold . ') must be between 0 - 100';
			throw new InvalidArgumentException($message);
		}
		$this->outputOptions[] = " -sepia-tone " . $threshold . '% ';
		$this->dirty();
		return $this;
	}
	/**
	 * Add polaroid effect to the image
	 *
	 * @param integer $angle The threshold to use
	 *
	 * @return Convert
	 * @throws InvalidArgumentException
	 * @throws BadMethodCallException if angle has already been called
	 */
	public function polaroid($angle = 0)
	{
		if ($this->isOptionSet('polaroid', $this->inputOptions)) {
			throw new BadMethodCallException('Polaroid can only be called once.');
		}
		if (!is_numeric($angle)) {
			$message = 'The supplied angle (' .
			$angle . ') must be between 0 - 360';
			throw new InvalidArgumentException($message);
		}
		$this->inputOptions[] = " -polaroid " . $angle . '';
		$this->dirty();
		return $this;
	}
	/**
	 * Set the color of the border if border is set
	 *
	 * @param string $color The color of the border
	 *
	 * @return Convert
	 * @throws BadMethodCallException if borderColor has already been called
	 */
	public function borderColor($color = '#DFDFDF')
	{
		if ($this->isOptionSet('borderColor', $this->inputOptions)) {
			throw new BadMethodCallException('BorderColor can only be called once.');
		}
		//TODO Check if the color is valid
		$this->inputOptions[] = " -bordercolor " . $color . '';
		$this->dirty();
		return $this;
	}
}