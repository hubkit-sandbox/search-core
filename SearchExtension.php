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

namespace Rollerworks\Component\Search;

use Rollerworks\Component\Search\Field\FieldType;
use Rollerworks\Component\Search\Field\FieldTypeExtension;

/**
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
interface SearchExtension
{
    /**
     * Returns a type by name.
     *
     * @param string $name
     *
     * @throws Exception\InvalidArgumentException if the given type is not supported by this extension
     *
     * @return FieldType
     */
    public function getType(string $name): FieldType;

    /**
     * Returns whether the given type is supported.
     *
     * @param string $name
     *
     * @return bool Whether the type is supported by this extension
     */
    public function hasType(string $name): bool;

    /**
     * Returns the extensions for the given type.
     *
     * @param string $name
     *
     * @return FieldTypeExtension[]
     */
    public function getTypeExtensions(string $name): array;
}
