<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

trait DetectsRelationships
{
    /**
     * Get all relationships defined in the model.
     *
     * @return array
     */
    public function getAllRelationships(): array
    {
        $relationships = [];

        // Use reflection to get all public methods on the model
        $reflection = new ReflectionClass($this);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            // Skip the constructor and methods that start with 'get' or 'set'
            if ($method->isConstructor() || str_starts_with($method->name, 'get') || str_starts_with($method->name, 'set')) {
                continue;
            }

            // Skip methods that require parameters
            if ($method->getNumberOfParameters() > 0) {
                continue;
            }

            try {
                // Check if the method returns a relationship instance
                $returnType = $method->getReturnType();
                if ($returnType && is_subclass_of($returnType->getName(), Relation::class)) {
                    $relationships[] = $method->name; // Add the method as a relationship
                }
            } catch (\Throwable $e) {
                // Ignore any exceptions to avoid disrupting the loop
            }
        }

        return $relationships;
    }
}
