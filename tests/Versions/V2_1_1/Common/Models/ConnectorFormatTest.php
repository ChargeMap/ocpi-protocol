<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorFormat;
use PHPUnit\Framework\TestCase;

class ConnectorFormatTest extends TestCase
{
    public function getConstructorData(): iterable
    {
        yield 'Socket' => [
            'expectation' => ConnectorFormat::SOCKET(),
            'input' => 'SOCKET',
        ];

        yield 'Cable' => [
            'expectation' => ConnectorFormat::CABLE(),
            'input' => 'CABLE',
        ];
    }

    /**
     * @dataProvider getConstructorData()
     */
    public function testConstructor(ConnectorFormat $expectation, string $input): void
    {
        $connectorFormat = new ConnectorFormat($input);

        $this->assertEquals($expectation, $connectorFormat->getValue());
    }
}