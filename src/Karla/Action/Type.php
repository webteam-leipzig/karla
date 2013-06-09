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
use Karla\Support;
use Karla\Action;

/**
 * Class for handeling type action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Type implements Action
{

    /**
     * The type to use
     *
     * @var string
     */
    private $type;

    /**
     * The program to use
     *
     * @var Program
     */
    private $program;

    /**
     * Create a new type action
     *
     * @param Program $program
     *            The program to use
     * @param string $type
     *            The type to use
     *
     * @return void
     */
    public function __construct($program, $type)
    {
        $this->program = $program;
        $this->type = $type;
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
        $query->notWith('type', Query::ARGUMENT_TYPE_OUTPUT);
        if (! Support::imageTypes($this->program, $this->type)) {
            $message = 'The supplied colorspace (' . $this->type . ') is not supported by imagemagick';
            throw new \InvalidArgumentException($message);
        }
        $query->setOutputOption(" -type " . $this->type . ' ');
        return $query;
    }
}