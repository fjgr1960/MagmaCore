<?php

declare(strict_types=1);

namespace Magma\Yaml;

use Symfony\Component\Yaml\Yaml;
use Magma\Base\Exception\BaseException;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlConfig
{
  /**
   * isFileExists function
   *
   * @param string $filename
   * @return void
   * @throws BaseException
   */
  private function isFileExists(string $filename): void
  {
    if (!file_exists($filename)) {
      throw new BaseException("$filename does not exist!");
    }
  }

  /**
   * getYaml function
   *
   * @param string $yamlFile
   * @return mixed
   * @throws ParseException
   */
  public function getYaml(string $yamlFile): mixed
  {
    foreach (glob(CONFIG_PATH . DS .'*.yaml') as $file) {
      $this->isFileExists($file);
      $parts = parse_url($file);
      $path = $parts['path'];
      if (strpos($path, $yamlFile)) {
        return Yaml::parseFile($yamlFile);
      }
    }
  }

  /**
   * file function
   *
   * @param string $yamlFile
   * @return mixed
   * @throws ParseException
   */
  public static function file(string $yamlFile): mixed
  {
    return (new YamlConfig)->getYaml($yamlFile);
  }

}
