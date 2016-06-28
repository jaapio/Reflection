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
use PhpParser\Node\Stmt\Class_ as ClassNode;
use phpDocumentor\Reflection\Php\Class_ as ClassElement;
use phpDocumentor\Reflection\Interpret;
use phpDocumentor\Reflection\Reducer;

final class Class_ implements Reducer
{
    /**
     * @param Interpret $command
     * @param null $state
     * @return ClassElement
     * @throws \InvalidArgumentException
     */
    public function __invoke(Interpret $command, $state = null)
    {
        /** @var ClassNode $subject */
        $object = $command->subject();

        if ($object instanceof ClassNode) {
            $docBlockCommand = new Interpret($object->getDocComment(), $command->context());
            $docBlock = $command->interpreter()->interpret($docBlockCommand);
            return new ClassElement(
                $object->fqsen,
                $docBlock,
                $object->extends ? new Fqsen('\\' . $object->extends) : null,
                $object->isAbstract(),
                $object->isFinal()
            );
        }

        return $state;
    }
}
