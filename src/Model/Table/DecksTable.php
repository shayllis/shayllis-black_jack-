<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Event\Event;

class DecksTable extends Table
{
  private $kinds = ['hearts','spades','clubs','diamonds'];
  private $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'];

  public function initialize(array $config)
  {
    $this->setTable('decks');
  }

  public function generateDeck()
  {
    $cards = [];
    $numbers = [];

    foreach ($this->kinds as $kind) {
      foreach ($this->numbers as $number) {
        $cards[] = ['kind' => $kind, 'number' => $number];
      }
    }

    return $cards;
  }

  public function shuffle($deck)
  {
    shuffle($deck);
    return $deck;
  }

  public function pickCard(&$deck)
  {
    $card = array_shift($deck);
    return $card;
  }
}
