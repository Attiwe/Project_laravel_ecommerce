<?php

namespace App\Console;

/**
 * Composer scripts for this project.
 * 
 * This class is called during the post-autoload-dump event to patch
 * vendor files that contain bugs before artisan commands are invoked.
 */
class ComposerScripts
{
    /**
     * Apply the ContainerCommandLoader patch before running artisan commands.
     *
     * This fixes a bug in Laravel where commands with #[AsCommand] attribute
     * are lazily resolved via ContainerCommandLoader without having setLaravel()
     * called on them, causing:
     *   "Call to a member function make() on null" in Command.php:173
     *
     * Affected: laravel/framework v11.44.x through v11.51.x (and possibly later).
     */
    public static function postAutoloadDump(): void
    {
        $file = __DIR__ . '/../../vendor/laravel/framework/src/Illuminate/Console/ContainerCommandLoader.php';

        if (!file_exists($file)) {
            return;
        }

        $content = file_get_contents($file);

        // Check if our fix is already present (idempotent)
        if (strpos($content, 'setLaravel') !== false) {
            return;
        }

        // Apply the fix: inject setLaravel() call after container resolution
        $search  = 'return $this->container->get($this->commandMap[$name]);';
        $replace = '$command = $this->container->get($this->commandMap[$name]);' . "\n\n" .
                   '        if ($command instanceof \\Illuminate\\Console\\Command && method_exists($this->container, \'make\')) {' . "\n" .
                   '            $command->setLaravel($this->container);' . "\n" .
                   '        }' . "\n\n" .
                   '        return $command;';

        if (strpos($content, $search) !== false) {
            $patched = str_replace($search, $replace, $content);
            file_put_contents($file, $patched);
            echo "  [patch] Applied ContainerCommandLoader::setLaravel() fix for laravel/framework.\n";
        }
    }
}
