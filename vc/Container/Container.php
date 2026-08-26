<?php

declare( strict_types=1 );

namespace VC\Container;

use Closure;
use ReflectionClass;
use ReflectionNamedType;

class Container {

	private array $registry = [];

	public function set( string $name, Closure $callback ): void {
		$this->registry[ $name ] = $callback;
	}

	public function get( string $className ): object {

		if ( array_key_exists( $className, $this->registry ) ) {

			return $this->registry[$className]();

		}

		$reflector = new ReflectionClass( $className );

		$constructor = $reflector->getConstructor();

		if ( $constructor === null ) {

			return new $className;

		}

		$dependencies = [];

		foreach ( $constructor->getParameters() as $parameter ) {

			$type = $parameter->getType();


			if ( $type === null ) {

				throw new ContainerException( "Constructor parameter '{$parameter->getName()}' 
                      in the $className class 
                      has no type declaration" );

			}

			if ( $type->isBuiltIn() ) {

				throw new ContainerException( "Unable to resolve constructor parameter
                      '{$parameter->getName()}'
                      of type '$type' in the $className class" );

			}

			if ( ! ( $type instanceof ReflectionNamedType ) ) {

				throw new ContainerException( "Constructor parameter '{$parameter->getName()}' 
                      in the $className class is an invalid type: '$type' 
                      - only single named types supported" );

			}

			$dependencies[] = $this->get( $type->getName() );
		}

		return new $className( ...$dependencies );
	}
}