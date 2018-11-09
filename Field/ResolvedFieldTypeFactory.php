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

namespace Rollerworks\Component\Search\Field;

use Rollerworks\Component\Search\Exception\InvalidArgumentException;

/**
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
interface ResolvedFieldTypeFactory
{
    /**
     * Resolves a field type.
     *
     * @param FieldType            $type
     * @param FieldTypeExtension[] $typeExtensions
     * @param ResolvedFieldType    $parent
     *
     * @throws InvalidArgumentException if the types parent cannot be retrieved from any extension
     */
    public function createResolvedType(FieldType $type, array $typeExtensions, ResolvedFieldType $parent = null): ResolvedFieldType;
}
