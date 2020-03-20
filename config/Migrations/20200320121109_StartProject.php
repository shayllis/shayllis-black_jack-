<?php
use Migrations\AbstractMigration;

class StartProject extends AbstractMigration
{
  /**
   * Change Method.
   *
   * More information on this method is available here:
   * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
   * @return void
   */
  public function change()
  {
    $this->table('decks')
      ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
      ->create();

    $this->table('cards')
      ->addColumn('deck_id', 'integer')
      ->addColumn('number', 'string', ['limit' => 1])
      ->addColumn('kind', 'string', ['limit' => 25])
      ->addForeignKey('deck_id', 'decks', 'id')
      ->create();
  }
}
