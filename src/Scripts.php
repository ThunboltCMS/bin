<?php

declare(strict_types=1);

namespace Thunbolt\Console;

class Scripts {

	public static function init(): void {
		if (php_sapi_name() !== 'cli') {
			Console::error('Run script in terminal.');
		}
		if (!Console::existScript('npm')) {
			Console::warning('npm script not exists. Ending.');
			exit(0);
		}

		$root = Console::findRoot();
		if (!file_exists($root . '/node_modules')) {
			chdir($root);
			Console::info('Installing npm...');
			system('npm install');
		}
	}

	public static function bowerInstall(): void {
		$root = Console::findRoot();
		if (Console::existScript('bower')) {
			$executor = 'bower';
		} else {
			$executor = $root . '/node_modules/.bin/bower';
			if (!file_exists($executor)) {
				Console::error('Cannot run bower. Not installed.');
			}
		}

		chdir($root);
		system($executor . ' install');
	}

	public static function grunt(): void {
		$root = Console::findRoot();
		if (Console::existScript('grunt')) {
			$executor = 'grunt';
		} else {
			$executor = $root . '/node_modules/grunt-cli/bin/grunt';
			if (!file_exists($executor)) {
				Console::error('Cannot run grunt. Not installed.');
			}
		}

		chdir($root);
		system($executor);
	}

	public static function composer(): void {
		if (!Console::existScript('composer')) {
			Console::error('Composer command not exists.');
		}

		$root = Console::findRoot();
		chdir($root);
		system('composer dump-autoload -o');
	}

	public static function production(): void {
		Console::command('Minify css/js:');
		self::grunt();
		Console::command('Composer dump-autoload:');
		self::composer();
	}

}
