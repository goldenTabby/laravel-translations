<?php namespace Tabby\Translations\Tests;

use Orchestra\Testbench\TestCase;
use Tabby\Translations\TranslationsSeeder;

class TranslationTest extends TestCase
{
    /**
     * Before test run
     */
    public function setUp()
    {
        parent::setUp();

        cache()->flush();

        $this->artisan('migrate', [ '--realpath' => realpath(__DIR__ . '/../src/migrations') ]);
        $this->seed(TranslationsSeeder::class);
    }

    /**
     * After test run
     */
    public function tearDown()
    {
        $this->artisan('migrate:rollback', [ '--realpath' => realpath(__DIR__ . '/../src/migrations') ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'tabby-translations');
        $app['config']->set('database.connections.tabby-translations', [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'port'      => '3306',
            'database'  => 'package-test',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null
        ]);
    }

    /**
     * Return unknown key when passed
     */
    public function testUnknownKeyReturnsItself()
    {
        $this->assertEquals('unknownKey', t('unknownKey'));
    }

    /**
     * Return empty string when passed
     */
    public function testEmptyKeyReturnsEmpty()
    {
        $this->assertEquals('', t(''));
    }

    /**
     * Return translation when known key passed
     */
    public function testStoredKeyReturnsTranslation()
    {
        $this->assertEquals('test', t('test'));
    }

    /**
     *  Throw exception when nothing passed
     */
    public function testPassNoParamReturnsException()
    {
        $this->expectException('Exception');
        t();
    }

    /**
     * Throw exception when number passed
     */
    public function testPassingNotStringReturnsException()
    {
        $this->expectException('Exception');
        t(0);
    }

    /**
     * Return passed default value
     */
    public function testReturnDefaultIfPassed()
    {
        $this->assertEquals('Default', t('test', 'Default'));
    }

    /**
     * Return translation string with replaced parameter placeholder
     */
    public function testFillTranslationWithParams()
    {
        $this->assertEquals('Translation with ParamString', t('test-with-params', [ 'param' => 'ParamString' ]));
    }
}
