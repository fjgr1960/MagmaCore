<?php

declare(strict_types=1);

namespace Magma\Application;

class Application
{
  /**
   * Class constructor
   * 
   * @param string $appRoot
   * @return void
   */
  public function __construct(protected string $appRoot)
  {}

  /**
   * run function
   *
   * @return self
   */
  public function run(): self
  {
    $this->constants();

    if (version_compare($phpVersion = PHP_VERSION, $coreVersion = Config::MAGMA_MIN_VERSION, '<'))
      die(sprintf('You are running PHP %s, but required PHP %s at least!', $phpVersion, $coreVersion));

    $this->environment();
    $this->errorHandler();

    return $this;
  }

  /**
   * constants function
   *
   * @return void
   */
  private function constants(): void
  {
    define('DS', DIRECTORY_SEPARATOR);
    define('APP_ROOT', $this->appRoot);
    define('CONFIG_PATH', APP_ROOT . DS .'Config');
    define('TEMPLATE_PATH', APP_ROOT . DS .'App/templates');
    define('LOG_DIR', APP_ROOT . DS .'tmp/log');
  }

  /**
   * environment function
   *
   * @return void
   */
  private function environment(): void
  {
    ini_set('default_charset', 'UTF-8');
  }

  /**
   * errorHandler function
   *
   * @return void
   */
  private function errorHandler(): void
  {
    error_reporting(E_ALL | E_STRICT);
    set_error_handler('Magma\ErrorHandling\ErrorHandling::errorHandler');
    set_exception_handler('Magma\ErrorHandling\ErrorHandling::exceptionHandler');
  }

}
