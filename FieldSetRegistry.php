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

use Rollerworks\Component\Search\Exception\InvalidArgumentException;

interface FieldSetRegistry
{
    /**
     * Returns a FieldSetConfiguratorInterface by name.
     *
     * @param string $name
     *
     * @throws InvalidArgumentException if the configurator can not be retrieved
     *
     * @return FieldSetConfigurator
     */
    public function getConfigurator(string $name): FieldSetConfigurator;

    /**
     * Returns whether the given FieldSetConfigurator is supported.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasConfigurator(string $name): bool;
}
