<?php

namespace Thunbolt\Console;

class Console {

	public static function chooseBool() {
		echo 'Your choose (y/n): ';
		$stdin = fopen('php://stdin', 'r');
		$response = strtolower(fgetc($stdin));
		if (!in_array($response, ['y', 'n'])) {
			self::warning('Please type y or n');

			return self::chooseBool();
		}

		return $response === 'y';
	}

	public static function error($msg) {
		fprintf(STDERR, "\033[31m" . $msg . "\033[39m\n");
		exit(1);
	}

	public static function warning($msg) {
		fprintf(STDOUT, "\033[33m" . $msg . "\033[39m\n");
	}

	public static function info($msg) {
		fprintf(STDOUT, $msg . "\n");
	}

	public static function bold($msg) {
		return "\033[1m" . $msg . "\033[22m";
	}

	public static function command($msg) {
		fprintf(STDOUT, "\033[35m" . self::bold($msg) . "\033[39m\n");
	}

	public static function existScript($name) {
		exec('command -v ' . $name, $x, $return);

		return $return === 0;
	}

}
