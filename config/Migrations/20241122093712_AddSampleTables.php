<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddSampleTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'uuid', [
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

        $this->table('posts')
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('text', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->addForeignKey(
                'user_id',
                'users'
            )
            ->create();

        $this->table('comments')
            ->addColumn('status', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('post_id', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('text', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->addIndex(
                [
                    'post_id',
                ]
            )
            ->addForeignKey(
                'user_id',
                'users'
            )
            ->addForeignKey(
                'post_id',
                'posts'
            )
            ->create();

    }
}
