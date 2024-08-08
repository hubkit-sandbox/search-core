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

namespace Rollerworks\Component\Search\Extension\Core\DataTransformer;

use Rollerworks\Component\Search\DataTransformer;
use Rollerworks\Component\Search\Exception\TransformationFailedException;

final class OrderToLocalizedTransformer implements DataTransformer
{
    private array $alias;
    private array $viewLabel;
    private string $case;

    public function __construct(array $alias, array $viewLabel, string $case = OrderTransformer::CASE_UPPERCASE)
    {
        $this->case = $case;
        $this->alias = $alias;
        $this->viewLabel = $viewLabel;
    }

    public function transform($value)
    {
        if ($value === null) {
            return '';
        }

        if (! \is_string($value)) {
            throw new TransformationFailedException('Expected a string or null.');
        }

        switch ($this->case) {
            case OrderTransformer::CASE_LOWERCASE:
                $value = mb_strtolower($value);

                break;

            case OrderTransformer::CASE_UPPERCASE:
                $value = mb_strtoupper($value);

                break;
        }

        if (! isset($this->viewLabel[$value])) {
            throw new TransformationFailedException(sprintf('No localized label configured for "%s".', $value));
        }

        return $this->viewLabel[$value];
    }

    public function reverseTransform($value)
    {
        if ($value !== null && ! \is_string($value)) {
            throw new TransformationFailedException('Expected a string or null.');
        }

        if ($value === '') {
            return null;
        }

        switch ($this->case) {
            case OrderTransformer::CASE_LOWERCASE:
                $value = mb_strtolower($value);

                break;

            case OrderTransformer::CASE_UPPERCASE:
                $value = mb_strtoupper($value);

                break;
        }

        if (! isset($this->alias[$value])) {
            throw new TransformationFailedException(
                sprintf(
                    'Invalid sort direction "%1$s" specified, expected one of: "%2$s"',
                    $value,
                    implode('", "', array_keys($this->alias))
                ),
                0,
                null,
                'This value is not a valid sorting direction. Accepted directions are "{{ directions }}".',
                ['{{ directions }}' => mb_strtolower(implode('", "', array_unique(array_keys($this->alias))))]
            );
        }

        return $this->alias[$value];
    }
}
