<?php

declare(strict_types=1);

/*
 * This file is part of the RollerworksSearch package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Search\Exporter;

use Rollerworks\Component\Search\Field\FieldConfig;
use Rollerworks\Component\Search\FieldSet;
use Rollerworks\Component\Search\SearchCondition;
use Rollerworks\Component\Search\Value\Compare;
use Rollerworks\Component\Search\Value\ExcludedRange;
use Rollerworks\Component\Search\Value\PatternMatch;
use Rollerworks\Component\Search\Value\Range;
use Rollerworks\Component\Search\Value\ValuesBag;
use Rollerworks\Component\Search\Value\ValuesGroup;

/**
 * Exports the SearchCondition as a JSON object.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
final class JsonExporter extends AbstractExporter
{
    /**
     * Exports a search condition.
     *
     * @param SearchCondition $condition The search condition to export
     *
     * @return string
     */
    public function exportCondition(SearchCondition $condition): string
    {
        return json_encode($this->exportGroup($condition->getValuesGroup(), $condition->getFieldSet(), true));
    }

    protected function exportGroup(ValuesGroup $valuesGroup, FieldSet $fieldSet, bool $isRoot = false): array
    {
        $result = [];
        $fields = $valuesGroup->getFields();

        foreach ($fields as $name => $values) {
            if ($fieldSet->isPrivate($name) || 0 === $values->count()) {
                continue;
            }

            $exportedValue = $this->exportValues($values, $fieldSet->get($name));

            // Only export fields with actual values.
            if (count($exportedValue) > 0) {
                $result['fields'][$name] = $exportedValue;
            }
        }

        foreach ($valuesGroup->getGroups() as $group) {
            $result['groups'][] = $this->exportGroup($group, $fieldSet, false);
        }

        if (isset($result['fields']) && ValuesGroup::GROUP_LOGICAL_OR === $valuesGroup->getGroupLogical()) {
            $result['logical-case'] = 'OR';
        }

        return $result;
    }

    protected function exportValues(ValuesBag $valuesBag, FieldConfig $field): array
    {
        $exportedValues = [];

        foreach ($valuesBag->getSimpleValues() as $value) {
            $exportedValues['simple-values'][] = $this->modelToNorm($value, $field);
        }

        foreach ($valuesBag->getExcludedSimpleValues() as $value) {
            $exportedValues['excluded-simple-values'][] = $this->modelToNorm($value, $field);
        }

        foreach ($valuesBag->get(Range::class) as $value) {
            $exportedValues['ranges'][] = $this->exportRangeValue($value, $field);
        }

        foreach ($valuesBag->get(ExcludedRange::class) as $value) {
            $exportedValues['excluded-ranges'][] = $this->exportRangeValue($value, $field);
        }

        foreach ($valuesBag->get(Compare::class) as $value) {
            $exportedValues['comparisons'][] = [
                'operator' => $value->getOperator(),
                'value' => $this->modelToNorm($value->getValue(), $field),
            ];
        }

        foreach ($valuesBag->get(PatternMatch::class) as $value) {
            $exportedValues['pattern-matchers'][] = [
                'type' => $value->getType(),
                'value' => $value->getValue(),
                'case-insensitive' => $value->isCaseInsensitive(),
            ];
        }

        return $exportedValues;
    }

    protected function exportRangeValue(Range $range, FieldConfig $field): array
    {
        $result = [
            'lower' => $this->modelToNorm($range->getLower(), $field),
            'upper' => $this->modelToNorm($range->getUpper(), $field),
        ];

        if (!$range->isLowerInclusive()) {
            $result['inclusive-lower'] = false;
        }

        if (!$range->isUpperInclusive()) {
            $result['inclusive-upper'] = false;
        }

        return $result;
    }
}
