<?php

class PM2
{

    /**
     * Start PM2 process
     *
     * @param string $script Path to script
     * @param string|null $name Name for script
     * @param string|null $namespace Namespace for script
     * @param string $output_log Specify out log file
     * @param string $error_log Specify error log file
     * @param string|null $args Additional arguments separated by a space
     * @return bool
     */
    public function start(
        string $script,
        string $name = null,
        string $namespace = null,
        string $output_log = "/dev/null",
        string $error_log = "/dev/null",
        string $args = null
    ): bool
    {
        $name = (is_null($name)) ? ' ' : ' --name "' . $name . '" ';
        $namespace = (is_null($namespace)) ? ' ' : ' --namespace "' . $namespace . '" ';
        $args = (is_null($args)) ? ' ' : ' -- ' . $args . ' ';

        $command = 'pm2 start ' . $script .
            $name .
            $namespace .
            '-o "' . $output_log . '" ' .
            '-e "' . $error_log . '" ' .
            '-m ' .
            '-f' .
            $args;

        exec($command, $result, $code);

        if ($code === 0) {
            echo "[OK] \"$script\" process started" . PHP_EOL;
            return true;
        } else {
            echo "[ERROR] Failed to start \"$script\" process" . PHP_EOL;
            return false;
        }
    }

    /**
     * Stops all PM2 processes
     *
     * @return bool
     */
    public function stopAll(): bool
    {
        exec('pm2 stop all -m', $result, $code);

        if ($code === 0) {
            echo "[OK] All PM2 processes are stopped" . PHP_EOL;
            return true;
        } else {
            echo "[ERROR] Failed to stop PM2 processes" . PHP_EOL;
            return false;
        }
    }

    /**
     * Removes all PM2 processes
     *
     * @return bool
     */
    public function deleteAll(): bool
    {
        exec('pm2 delete all -m', $result, $code);

        if ($code === 0) {
            echo "[OK] All PM2 processes are removed" . PHP_EOL;
            return true;
        } else {
            echo "[ERROR] Failed to remove PM2 processes" . PHP_EOL;
            return false;
        }
    }
}