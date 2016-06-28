<?php
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2010-2015 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection\Php\Reducer;


use phpDocumentor\Reflection\Interpret;
use phpDocumentor\Reflection\Reducer;

final class Dummy implements Reducer
{
    /**
     * @var
     */
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function __invoke(Interpret $command, $state = null)
    {
        if ($state === null) {
            return $this->result;
        }

        return $state . ' ' . $this->result;
    }
}
