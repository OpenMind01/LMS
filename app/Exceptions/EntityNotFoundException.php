<?php

namespace Pi\Exceptions;

class EntityNotFoundException extends \Exception implements INotFoundException
{
    /**
     * @var string
     */
    private $entityType;
    /**
     * @var string
     */
    private $condition;
    /**
     * @var string
     */
    private $conditionValue;

    /**
     * EntityNotFoundException constructor.
     * @param string $entityType
     * @param string $condition
     * @param string $conditionValue
     */
    public function __construct($entityType, $condition, $conditionValue)
    {
        parent::__construct("Entity not found");

        $this->entityType = $entityType;
        $this->condition = $condition;
        $this->conditionValue = $conditionValue;
    }

    /**
     * @return string
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return string
     */
    public function getConditionValue()
    {
        return $this->conditionValue;
    }
}