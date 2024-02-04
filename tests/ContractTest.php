<?php

use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';
use App\ContractManagement;
use App\Contract;
use App\Load;

class ContractTest extends TestCase{
    /** @test */
    private $cm;

    protected function setUp(): void {
        $this->cm = new ContractManagement();
    }

    public function testCreateContract() {
        // Test creating a new contract
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $contract = $this->cm->getContract('123abc');
        $this->assertNotNull($contract);
        $this->assertEquals('NEW', $contract->status);
    }

    public function testCreateLoad() {
        // Assuming a contract '123abc' already exists
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $this->cm->createLoad('123abc', 'A1', 10);
        $contract = $this->cm->getContract('123abc');
        $loads = $contract->getLoads();
        $this->assertCount(1, $loads);
        $this->assertEquals(10, $loads[0]->quantity);
    }

    public function testDeleteContractWithLoads() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Cannot delete contract with loads.");

        $this->cm->createContract('test', 'CPO', 100, 1200);
        $this->cm->createLoad('test', 'L1', 50);
        $this->cm->deleteContract('test');
    }

    public function testDeleteLoad() {
        // Assuming a contract '123abc' already exists and has a load
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $this->cm->createLoad('123abc', 'A1', 10);
        $this->cm->deleteLoad('123abc', 'A1');
        $contract = $this->cm->getContract('123abc');
        $this->assertEmpty($contract->getLoads());
    }

    protected function tearDown(): void {
        // Clean up your test environment if necessary
    }
}