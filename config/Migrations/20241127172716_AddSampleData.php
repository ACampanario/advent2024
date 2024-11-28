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

        $this->execute("INSERT INTO public.posts (title, user_id, status, \"text\") VALUES('Post A', NULL, 'draft', 'Loren ipsum');");
        $this->execute("INSERT INTO public.posts (title, user_id, status, \"text\") VALUES('Post B', NULL, 'published', 'Lorem ipsum dolor sit amet');");
        $this->execute("INSERT INTO public.comments (status, user_id, post_id, \"text\") VALUES('approved', NULL, 1, 'This is a valid comment');");
        $this->execute("INSERT INTO public.comments (status, user_id, post_id, \"text\") VALUES('declined', NULL, 1, 'This is a invalid comment');");

    }

    public function down(): void
    {
        $this->execute('DELETE FROM orders');
    }
}
