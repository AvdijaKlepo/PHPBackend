<?php
namespace App\Models\Factory;

use App\Models\AbstractModels\AbstractAttribute;
use App\Models\AttributeModel\ColorAttribute;
use App\Models\AttributeModel\SizeAttribute;
use App\Models\AttributeModel\CapacityAttribute;
use App\Models\AttributeModel\Usb3PortsAttribute;
use App\Models\AttributeModel\TouchIDKeyboardAttribute;
use PDO;

class AttributeFactory
{

    public static function create(PDO $pdo, string $attributeName): AbstractAttribute
    {
        return match (strtolower($attributeName)) {
            'color' => new ColorAttribute($pdo),
            'size' => new SizeAttribute($pdo),
            'capacity' => new CapacityAttribute($pdo),
            'with usb 3 ports' => new Usb3PortsAttribute($pdo),
            'touch id in keyboard' => new TouchIDKeyboardAttribute($pdo),
            default => throw new \InvalidArgumentException("Unsupported attribute type: $attributeName"),
        };
    }
}
