<?php

namespace ByTIC\Hello\Tests\Utility {

    use ByTIC\Hello\Tests\AbstractTest;
    use ByTIC\Hello\Utility\CryptHelper;

    /**
     * Class CryptHelperTest
     * @package ByTIC\Hello\Tests\Utility
     */
    class CryptHelperTest extends AbstractTest
    {
        public static function testKeyPathFromStoragePath()
        {
            $path = CryptHelper::keyPath('oath.key');
            self::assertSame(
                TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'oath.key',
                $path
            );
        }

        public static function testGenerateKeys()
        {
            CryptHelper::generateKeys();

            $files = ['oauth-private.key', 'oauth-public.key'];
            foreach ($files as $file) {
                $path = storage_path($file);
                self::assertFileExists($path);

                $content = file_get_contents($path);
                self::assertStringStartsWith('-----BEGIN', $content);
                self::assertStringEndsWith('KEY-----', $content);

                self::assertGreaterThan(100, filesize($path), "output file [{$file}] should be at least 100bytes");
                unlink($path);
            }
        }
    }
}

namespace {

    /**
     * @param $file
     * @return string
     */
    function storage_path($file)
    {
        return TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $file;
    }
}
