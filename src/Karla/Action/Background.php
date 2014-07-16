<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2013-05-26
 */
namespace Karla\Action;

use Karla\Query;
use Karla\Action;
use Karla\Color;

/**
 * Class for handeling background action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Background implements Action
{

    /**
     * Color
     *
     * @var string
     */
    private $color;

    /**
     * Construct new background action
     *
     * @param integer $color
     *            Color
     *
     * @return void
     * @throws \InvalidArgumentException If the color supplied could not be parsed.
     */
    public function __construct($color)
    {
        if (Color::validHexColor($color) || Color::validRgbColor($color) || Color::validColorName($color)) {
            $this->color = $color;
        } else {
            throw new \InvalidArgumentException('The color supplied could not be parsed.');
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @param Query $query
     *            The query to add the action to
     * @return Query
     * @see Action::perform()
     */
    public function perform(Query $query)
    {
        $query->notWith('background', Query::ARGUMENT_TYPE_INPUT);
        if (Color::validColorName($this->color)) {
            $query->setInputOption(' -background ' . $this->color);
        } else {
            $query->setInputOption(' -background "' . $this->color . '"');
        }
        return $query;
    }
}
