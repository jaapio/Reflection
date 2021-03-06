<?php
declare(strict_types=1);

namespace phpDocumentor\Reflection\Php\Factory;

use phpDocumentor\Reflection\DocBlock as DocBlockInstance;
use phpDocumentor\Reflection\Php\ProjectFactoryStrategy;
use phpDocumentor\Reflection\Php\StrategyContainer;
use phpDocumentor\Reflection\Types\Context;
use PhpParser\Comment\Doc;
use PhpParser\Node;

abstract class AbstractFactory implements ProjectFactoryStrategy
{
    /**
     * Returns true when the strategy is able to handle the object.
     *
     * @param mixed $object object to check.
     */
    abstract public function matches($object): bool;

    final public function create($object, StrategyContainer $strategies, ?Context $context = null)
    {
        if (!$this->matches($object)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s cannot handle objects with the type %s',
                    __CLASS__,
                    is_object($object) ? get_class($object) : gettype($object)
                )
            );
        }

        return $this->doCreate($object, $strategies, $context);
    }

    abstract protected function doCreate($object, StrategyContainer $strategies, ?Context $context = null);

    /**
     * @param Node|PropertyIterator|ClassConstantIterator|Doc $stmt
     * @return mixed a child of Element
     */
    protected function createMember($stmt, StrategyContainer $strategies, ?Context $context = null)
    {
        $strategy = $strategies->findMatching($stmt);
        return $strategy->create($stmt, $strategies, $context);
    }

    /**
     * @return null|DocBlockInstance
     */
    protected function createDocBlock(?StrategyContainer $strategies = null, ?Doc $docBlock = null, ?Context $context = null)
    {
        if ($docBlock === null || $strategies === null) {
            return null;
        }

        return $this->createMember($docBlock, $strategies, $context);
    }
}
