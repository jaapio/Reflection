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

use phpDocumentor\Reflection\DocBlockFactoryInterface;
use phpDocumentor\Reflection\Interpret;
use phpDocumentor\Reflection\Reducer;
use PhpParser\Comment\Doc;

final class DocBlock implements Reducer
{
    /**
     * @var DocBlockFactoryInterface
     */
    private $docBlockFactory;

    public function __construct(DocBlockFactoryInterface $docBlockFactory)
    {
        $this->docBlockFactory = $docBlockFactory;
    }

    public function __invoke(Interpret $command, $state = null)
    {
        $subject = $command->subject();
        if ($subject instanceof Doc) {
            return $this->docBlockFactory->create($subject->getText(), $command->context());
        }

        return $state;
    }
}
