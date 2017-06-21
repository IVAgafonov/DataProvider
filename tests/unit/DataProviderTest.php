<?php
namespace Tests\unit;

/**
 * @coversDefaultClass \IVAgafonov\System\DataProvider
 */
class DataProviderTest extends \Codeception\Test\Unit
{
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCreateObjectWithInvalidConfig()
    {
        $config = [];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid database params');

        $dataProvider = new \IVAgafonov\System\DataProvider($config);
    }

    public function testCreateObjectWithInvalidDb()
    {
        $config = [
            'dbHost' => '255.255.255.255',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("SQLSTATE[HY000] [2002] Network is unreachable");

        $dataProvider = new \IVAgafonov\System\DataProvider($config);
    }

    public function testCreateObjectWithValidConfig()
    {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);
        $this->assertInstanceOf('\IVAgafonov\System\DataProviderInterface', $dataProvider);
    }

    public function testGetValue() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);
        $value = $dataProvider->getValue("SELECT Test FROM test WHERE Id = 1");
        $this->assertEquals('test', $value);
    }

    public function testGetValueInvalid() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);
        $value = $dataProvider->getValue("SELECT Test FROM test WHERE Id = 2");
        $this->assertEquals(false, $value);
    }

    public function testGetArray() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $arrays = $dataProvider->getArray("SELECT * FROM test WHERE Id = 1");
        $this->assertEquals('test', $arrays['Test']);
    }

    public function testGetArrayInvalid() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $arrays = $dataProvider->getArray("SELECTS * FROM test WHERE Id = 2");
        $this->assertEquals(false, $arrays);
    }

    public function testGetArrays() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $arrays = $dataProvider->getArrays("SELECT * FROM test WHERE Id = 1");
        $this->assertArrayHasKey(0, $arrays);
        $this->assertEquals('test', $arrays[0]['Test']);
    }

    public function testGetArraysInvalid() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $arrays = $dataProvider->getArrays("SELECTS * FROM test WHERE Id = 2");
        $this->assertEquals(false, $arrays);
    }

    public function testDoQueryAndGetAffectedRows() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $dataProvider->doQuery("UPDATE test SET Test = 'testtest' WHERE Id = 1");
        $affectedRows = $dataProvider->getAffectedRows();
        $this->assertEquals(1, $affectedRows);
        $dataProvider->doQuery("UPDATE test SET Test = 'test' WHERE Id = 1");
        $affectedRows = $dataProvider->getAffectedRows();
        $this->assertEquals(1, $affectedRows);
    }

    public function testGetErrorAndErrno() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $dataProvider->doQuery("INSERT INTO test SET Test = 'testtest'");
        $insertId = $dataProvider->getLastInsertId();
        $this->assertEquals(2, $insertId);

        $dataProvider->doQuery("DELETE FROM test WHERE Id = 2");
        $affectedRows = $dataProvider->getAffectedRows();
        $this->assertEquals(1, $affectedRows);

        $dataProvider->doQuery("INSERT INTO test SET Test2 = 'testtest'");
        $error = $dataProvider->getLastError();
        $errno = $dataProvider->getLastErrno();
        $insertId = $dataProvider->getLastInsertId();

        $this->assertArrayHasKey(0, $error);
        $this->assertEquals('42S22', $error[0]);
        $this->assertEquals('42S22', $errno);
        $this->assertEquals(0, $insertId);
        $this->assertEquals(false, $dataProvider->getAffectedRows());
    }

    public function testGetObject() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $obj = $dataProvider->getObject("SELECT * FROM test WHERE Id = 1", '\stdClass');

        $this->assertInstanceOf('\stdClass', $obj);
        $this->assertObjectHasAttribute('Test', $obj);
        $this->assertEquals('test', $obj->Test);
    }

    public function testGetObjectInvalid() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $obj = $dataProvider->getObject("SELECTS * FROM test WHERE Id = 1", '\stdClass');

        $this->assertEquals(false, $obj);
    }

    public function testGetObjects() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $obj = $dataProvider->getObjects("SELECT * FROM test WHERE Id = 1", '\stdClass');

        $this->arrayHasKey(0, $obj);
        $this->assertInstanceOf('\stdClass', $obj[0]);
        $this->assertObjectHasAttribute('Test', $obj[0]);
        $this->assertEquals('test', $obj[0]->Test);
    }

    public function testGetObjectsInvalid() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $obj = $dataProvider->getObjects("SELECTS * FROM test WHERE Id = 1", '\stdClass');

        $this->assertEquals(false , $obj);
    }

    public function testQuote() {
        $config = [
            'dbHost' => '127.0.0.1',
            'dbName' => 'test',
            'dbUser' => 'travis',
            'dbPass' => ''
        ];

        $dataProvider = new \IVAgafonov\System\DataProvider($config);

        $quotedStr = $dataProvider->quote('str');

        $this->assertEquals("'str'", $quotedStr);
    }
}