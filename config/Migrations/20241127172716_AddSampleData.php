<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddSampleData extends AbstractMigration
{
    public function up(): void
    {
        function randomFloat($min, $max, $decimals = 2): float
        {
            $factor = pow(10, $decimals);
            return mt_rand($min * $factor, $max * $factor) / $factor;
        }

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'total' => randomFloat(100, 1000),
                'created' => date('Y-m-d H:i:s', strtotime("-" . mt_rand(0, 365) . " days")),
            ];
        }

        $this->table('orders')
            ->insert($data)
            ->saveData();
    }

    public function down(): void
    {
        $this->execute('DELETE FROM orders');
    }
}
