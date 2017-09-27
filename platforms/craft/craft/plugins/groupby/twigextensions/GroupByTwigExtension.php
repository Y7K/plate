<?php

namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class GroupByTwigExtension extends \Twig_Extension
{
    private $by;
    private $attrHandle;
    private $unGrouped;
    private $groupKey;
    private $groups;

    public function getName()
    {
        return 'Group By Twig Extension';
    }

    public function getFilters()
    {
        $returnArray = array();
        $methods = array(
            'groupBy'
        );

        foreach ($methods as $methodName) {
            $returnArray[$methodName] = new \Twig_Filter_Method($this, $methodName);
        }

        return $returnArray;
    }

    public function groupBy($elements, $by, $unGrouped = false)
    {
        $this->unGrouped = $unGrouped;
        $this->groupKey = false;
        $this->groups = array();

        foreach ($elements as $element) {
            $this->by = explode('.', $by);
            $this->attrHandle = array_shift($this->by);
            $this->groupKey = false;
            $context = !empty($element->{$this->attrHandle}) ? $element->{$this->attrHandle} : false;
            $this->_toGroup($element, $context);
        }

        // Only unique entries per group
        foreach ($this->groups as &$group) {
            $group = array_unique($group);
        }

        // Put unGrouped at the end
        if ($unGrouped && isset($this->groups[$unGrouped])) {
            $unGroupedItems = $this->groups[$unGrouped];
            unset($this->groups[$unGrouped]);
            $this->groups[$unGrouped] = $unGroupedItems;
        }

        return $this->groups;
    }

    public function _toGroup($element, $context)
    {
        if ($context instanceof ElementCriteriaModel) {
            $context = $context->find();
        }

        if (!empty($context)) {
            if (is_string($context)) {
                $this->groupKey = $context;
            } elseif (is_array($context)) {
                foreach ($context as $subContext) {
                    $this->_toGroup($element, $subContext);
                }
            } else {
                if (!empty($this->attrHandle)) {
                    $this->attrHandle = array_shift($this->by);

                    if ($this->attrHandle) {

                        // Use DateTime methods, not props
                        if ($context instanceof DateTime) {
                            $attr = $context->{$this->attrHandle}();
                        } else {
                            $attr = $context->{$this->attrHandle};
                        }

                        $this->_toGroup($element, $attr);
                    }
                }
            }
        } elseif ($this->unGrouped !== false) {
            $this->groupKey = $this->unGrouped;
        }


        // If we have a key, add element to main array
        if ($this->groupKey !== false) {
            $this->groups[$this->groupKey][] = $element;
        }

        return $this->groups;
    }
}
