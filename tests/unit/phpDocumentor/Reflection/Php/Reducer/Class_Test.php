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


use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Interpret;
use phpDocumentor\Reflection\Interpreter;
use phpDocumentor\Reflection\Php\Class_ as ClassElement;
use PhpParser\Node\Stmt\Class_ as ClassNode;

class Class_Test extends \PHPUnit_Framework_TestCase
{
    public function testCreatesClassElement()
    {
        $classNode = new ClassNode('MyClass', ['type' => ClassNode::MODIFIER_FINAL]);
        $classNode->fqsen = new Fqsen('\project\MyClass');
        $command = new Interpret($classNode);
        $command = $command->usingInterpreter(new Interpreter());

        $fixture = new Class_();
        /** @var ClassElement $result */
        $result = $fixture($command);

        $this->assertInstanceOf(ClassElement::class, $result);
        $this->assertEquals(new Fqsen('\project\MyClass'), $result->getFqsen());
        $this->assertTrue($result->isFinal());
    }
}
