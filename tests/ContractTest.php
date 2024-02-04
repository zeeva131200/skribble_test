<?php

use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

use App\ContractManagement;
use App\Contract;
use App\Load;

class ContractTest extends TestCase
{
    /** @test */
    private $cm;

    protected function setUp(): void
    {
        $this->cm = new ContractManagement();
    }

    public function testCreateContract()
    {
        // Test for creating new contract
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $contract = $this->cm->getContract('123abc');
        $this->assertNotNull($contract);
    }

    public function testCreateLoad()
    {
        // Test for create load
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $this->cm->createLoad('123abc', 'A1', 10);
        $contract = $this->cm->getContract('123abc');
        $loads = $contract->getLoads();
        $this->assertCount(1, $loads);
        $this->assertEquals(10, $loads[0]->quantity);
    }

    public function testDeleteContractWithLoads()
    {
        //Test for delete contract (with load)
        $this->cm->createContract('test', 'CPO', 100, 1200);
        $this->cm->createLoad('test', 'L1', 50);
        $this->cm->deleteContract('test');
        $contract = $this->cm->getContract('test');
        $this->assertNull($contract);
    }

    public function testDeleteLoad()
    {
        //  Test for delete load
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $this->cm->createLoad('123abc', 'A1', 10);
        $this->cm->deleteLoad('123abc', 'A1');
        $contract = $this->cm->getContract('123abc');
        $this->assertEmpty($contract->getLoads());
    }

    public function testCopyLoad()
    {
        //test for copying load
        $this->cm->createContract('123abc', 'CPO', 100, 1200);
        $this->cm->createLoad('123abc', 'A1', 10);
        $this->cm->createContract('456def', 'CPK', 80, 1400);
        $this->cm->createLoad('456def', 'A2', 70);
        $targetContract = $this->cm->getContract('456def');
        $this->cm->copyLoad('123abc', '456def', 'A1');
        $loadsInTarget = $targetContract->getLoads();

        $foundA1 = false;
        foreach ($loadsInTarget as $load) {
            if ($load->getLoadId() === 'A1') {
                $foundA1 = true;
                break;
            }
        }
        $this->assertTrue($foundA1);
        //$this->assertEquals('A1', $loadsInTarget[0]->getLoadId());
    }
}
