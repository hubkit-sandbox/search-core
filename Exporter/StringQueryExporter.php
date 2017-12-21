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

/**
 * Exports the SearchCondition as StringQuery string.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
final class StringQueryExporter extends StringExporter
{
    private $labelResolver;

    /**
     * Constructor.
     *
     * @param callable|null $labelResolver A callable to resolve the actual label
     *                                     of the field, receives a
     *                                     FieldConfigInterface instance.
     *                                     If null the `label` option value is
     *                                     used instead
     */
    public function __construct(callable $labelResolver = null)
    {
        $this->labelResolver = $labelResolver ?? function (FieldConfig $field) {
            return $field->getOption('label', $field->getName());
        };
    }

    protected function resolveLabels(FieldSet $fieldSet): array
    {
        $labels = [];
        $callable = $this->labelResolver;

        foreach ($fieldSet->all() as $name => $field) {
            $labels[$name] = $callable($field);
        }

        return $labels;
    }
}
