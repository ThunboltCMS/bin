<?php

declare(strict_types=1);

namespace Thunbolt\Console;

class Console {

	/** @var string */
	private static $root;

	public static function chooseBool(): bool {
		echo 'Your choose (y/n): ';
		$stdin = fopen('php://stdin', 'r');
		$response = strtolower(fgetc($stdin));
		if (!in_array($response, ['y', 'n'])) {
			self::warning('Please type y or n');

			return self::chooseBool();
		}

		return $response === 'y';
	}

	public static function error(string $msg): void {
		fprintf(STDERR, "\033[31m" . $msg . "\033[39m\n");
		exit(1);
	}

	public static function warning(string $msg): void {
		fprintf(STDOUT, "\033[33m" . $msg . "\033[39m\n");
	}

	public static function info(string $msg): void {
		fprintf(STDOUT, $msg . "\n");
	}

	public static function bold(string $msg): void {
		return "\033[1m" . $msg . "\033[22m";
	}

	public static function command(string $msg): void {
		fprintf(STDOUT, "\033[35m" . self::bold($msg) . "\033[39m\n");
	}

	public static function existScript(string $name): bool {
		exec('command -v ' . $name, $x, $return);

		return $return === 0;
	}

	public static function findRoot(): string {
		if (!self::$root) {
			$paths = [
				__DIR__ . '/../../../../',
				getcwd() . '/',
				getcwd() . '/../'
			];

			self::$root = '';
			foreach ($paths as $path) {
				if (file_exists($path . 'vendor')) {
					self::$root = $path;
					break;
				}
			}
		}

		return self::$root;
	}

}
