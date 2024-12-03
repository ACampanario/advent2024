<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddSampleData extends AbstractMigration
{
    public function up(): void
    {
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
