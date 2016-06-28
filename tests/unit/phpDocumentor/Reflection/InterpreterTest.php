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

namespace phpDocumentor\Reflection;

use Mockery as m;
use phpDocumentor\Reflection\Php\Reducer\Dummy;

class InterpreterTest extends \PHPUnit_Framework_TestCase
{
    public function testInterpretSingleReducer()
    {
        $reducerOne = new Dummy('result');
        $interpreter = new Interpreter([$reducerOne]);

        $result = $interpreter->interpret(new Interpret('test'));
        $this->assertEquals('result', $result);
    }

    public function testInterpretMultipleReducer()
    {
        $reducerOne = new Dummy('1');
        $reducerTwo = new Dummy('2');

        $interpreter = new Interpreter([$reducerOne, $reducerTwo]);

        $result = $interpreter->interpret(new Interpret('test'));
        $this->assertEquals('1 2', $result);
    }
}
